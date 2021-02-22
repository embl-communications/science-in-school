#!/bin/bash
 #set -xv
set -e
set -u

# determine root of repo
ROOT=$(cd $(dirname ${0})/../.. 2>/dev/null && pwd -P);

# set environment variables
set -a; source ${ROOT}/.env; set +a;

echo ""
echo "== Started background deployment script process check =="

declare -a FILE_NAME_ARRAY=($1)
filename_array_length=${#FILE_NAME_ARRAY[@]};
red="$(tput setaf 1)";
green="$(tput setaf 2)";
norm="$(tput sgr0)";
deploy_status_logfile=${DEPLOYMENT_LOG_MAIN_FOLDER}/${DEPLOYMENT_STATUS_LOGFILE};
current_date_time=$(date '+%d-%b-%Y %H:%M:%S');
server_hostname=`hostname`;


if [  ! -f $deploy_status_logfile ] ; then
    echo ""
    echo "Waiting for deployment status log file to generate..."
    while  [  ! -f $deploy_status_logfile ]
    do
         echo -n '.';
         sleep 5
    done
    echo ""
    echo "Finished found the status log file!!!"
    echo ""
fi

log_count=$(wc -l < $deploy_status_logfile)
if [ "$log_count" -lt "$filename_array_length" ] ; then
    echo ""
    echo "Waiting for deployment to complete for all ($filename_array_length) microsites..."
    while true
    do
        log_count=$(wc -l < $deploy_status_logfile)
        # Check if the current log has the updates for all microsites requested.
        # If not then wait until it get the logs
         if [ "$log_count" = "$filename_array_length" ] ; then
            break;
         fi
         echo -n '.';
        sleep 1
    done
    echo ""
    echo "Deployment Completed!!!"
    echo ""
fi

echo "Deployment status Log file found"
if [ $log_count = $filename_array_length ] ; then
    cat $deploy_status_logfile | sed -e "s/\(Failed*\)/${red}\1${norm}/g" -e "s/\(Success*\)/${green}\1${norm}/g";
fi

echo "";
echo "== Ended background deployment script process check =="

echo ""
echo "== Sending deployment log email to admin =="
cat $deploy_status_logfile | mail -s "Group site deployment status log for server [$server_hostname] - $current_date_time" sandeep@ebi.ac.uk


if grep -q "Failed" $deploy_status_logfile ; then
    echo "";
    echo >&2 "One or more microsite(s) deployment failed, marking build as ${red}failed${norm}; please check the logs in :- '${MICROSITE_DEBUG_LOG_FOLDER}'";
    echo "";
    exit 1;
fi
