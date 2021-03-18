<?php

// Fix params
$serverName = "vfwpsis_mariadb";
$dbName = "drupal";

// DB user and password should be passed as arguments
if (!isset($argc) || $argc < 3) {
    die("Too few arguments: php postprocess-urls.php dbuser dbpass");
}
$userName = $argv[1];
$password = $argv[2];

// create connection
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// First: Put simple node id urls in array: node-id => node-id-url
$nodeIdUrlArray = array();

$sql = "SELECT `nid`, CONCAT('node/', `nid`) AS `url` FROM `node` WHERE `type` IN ('page', 'article', 'issue');";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['nid'])) {
        continue;
    }
    $nodeIdUrlArray[$row['nid']] = $row['url'];
}
$statement->close();

echo "Array nodeIdUrlArray has " . count($nodeIdUrlArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($nodeIdUrlArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($nodeIdUrlArray)) . PHP_EOL;
echo PHP_EOL;


// Second: Get URL aliases: node-id => url alias
$urlAliasArray = array();

$sql = "
(SELECT REPLACE(`source`, 'node/', '') AS `nid`, `alias` AS `url`  FROM `url_alias` 
    WHERE `source` LIKE '%node/%' 
        AND `language` IN ('en', 'und', '')
        AND REPLACE(`source`, 'node/', '') IN 
            (SELECT `nid` FROM `node` WHERE `type` IN ('page', 'article', 'issue')))

UNION

(SELECT REPLACE(`source`, 'node/', '')  AS `nid`, CONCAT(`language`,'/',`alias`) AS `url`  FROM `url_alias` 
    WHERE `source` LIKE '%node/%' 
        AND `language` NOT IN ('en', 'und', '')
        AND REPLACE(`source`, 'node/', '') IN 
            (SELECT `nid` FROM `node` WHERE `type` IN ('page', 'article', 'issue')));";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['nid'])) {
        continue;
    }
    if (empty($row['url'])) {
        continue;
    }
    $urlAliasArray[$row['nid']] = $row['url'];
}
$statement->close();

echo "Array urlAliasArray has " . count($urlAliasArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($urlAliasArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($urlAliasArray)) . PHP_EOL;
echo PHP_EOL;


// Third: Get URL redirects: source url => target url
$redirectsArray = array();

$sql = "
SELECT `source`, `redirect`, `redirect` AS `url`, `language` FROM `redirect` 
	WHERE `language` IN  ('en') 
    AND `redirect` IN 
        (
    	    SELECT `alias` FROM `url_alias` WHERE `source` LIKE '%node/%' AND `language` IN ('en') AND REPLACE(`source`, 'node/', '') IN 
    	        (
        	        SELECT `nid` FROM `node` WHERE `type` IN ('page', 'article', 'issue')
        	    )
    	)
    
UNION

SELECT `source`, `redirect`, `redirect` AS `url`, `language` FROM `redirect` 
	WHERE 
    	`language` IN  ('und') 
    AND 
    `redirect` IN 
        (
            SELECT CONCAT(`language`,'/',`alias`)  FROM `url_alias` WHERE `source` LIKE '%node/%' AND `language` NOT IN ('en', 'und', '')
            AND REPLACE(`source`, 'node/', '') IN 
            (
                SELECT `nid` FROM `node` WHERE `type` IN ('page', 'article', 'issue')
        	)
    	)
    
UNION

SELECT `source`, `redirect`, CONCAT(`language`,'/',`redirect`) AS `url`, `language` FROM `redirect` 
	WHERE 
    	`language` NOT IN  ('en', 'und', '') 
    AND 
    `redirect` IN 
    (
        SELECT CONCAT(`language`,'/',`alias`)  FROM `url_alias` WHERE `source` LIKE '%node/%' AND `language` NOT IN ('en', 'und', '')
          AND REPLACE(`source`, 'node/', '') IN 
          (
            SELECT `nid` FROM `node` WHERE `type` IN ('page', 'article', 'issue')
            )
    )
    
UNION    

    SELECT `source`, `redirect`, `redirect` AS `url`, `language` FROM `redirect` 
	WHERE 
    	`redirect` LIKE '%node/%';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['source'])) {
        echo "ERROR REDIRECT" . $row['source'] . ' ' . $row['url'];
        continue;
    }
    if (empty($row['url'])) {
        echo "ERROR REDIRECT" . $row['source'] . ' ' . $row['url'];
        continue;
    }
    $redirectsArray[$row['source']] = $row['url'];
}
$statement->close();


echo "Array redirectsArray has " . count($redirectsArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($redirectsArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($redirectsArray)) . PHP_EOL;
echo PHP_EOL;

// Close connection to Drupal database
$conn->close();


// New connection to WP database
$dbName = 'docker';

// create connection
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Mapping between node ids and WP post ids
$mapNodeIdToPostIdArray = array();
$mapPostIdToNodeIdArray = array();

$sql = "SELECT `post_id` AS `postId`, `meta_value` AS `nodeId` FROM `wp_postmeta` WHERE `meta_key` = '_fgd2wp_old_node_id';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['nodeId'])) {
        continue;
    }
    if (empty($row['postId'])) {
        continue;
    }
    $mapNodeIdToPostIdArray[$row['nodeId']] = $row['postId'];
    $mapPostIdToNodeIdArray[$row['postId']] = $row['nodeId'];
}
$statement->close();

echo "Array mapNodeIdToPostIdArray has " . count($mapNodeIdToPostIdArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($mapNodeIdToPostIdArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($mapNodeIdToPostIdArray)) . PHP_EOL;
echo PHP_EOL;

echo "Array mapPostIdToNodeIdArray has " . count($mapPostIdToNodeIdArray) . " entries" . PHP_EOL;
echo "Min post id is: " . min(array_keys($mapPostIdToNodeIdArray)) . PHP_EOL;
echo "Max post id is: " . max(array_keys($mapPostIdToNodeIdArray)) . PHP_EOL;
echo PHP_EOL;


// Get language codes for WP ids: wp post id => language code
$languageCodeArray = array();

$sql = "SELECT `element_type` AS `postType`, `element_id` AS `postId`, `language_code` AS `language`  
    FROM `wp_icl_translations` 
    WHERE `element_type` IN ('post_post', 'post_page', 'post_issue');";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['postId'])) {
        continue;
    }
    if (empty($row['language'])) {
        continue;
    }
    $languageCodeArray[$row['postId']] = $row['language'];
}
$statement->close();

echo "Array languageCodeArray has " . count($languageCodeArray) . " entries" . PHP_EOL;
echo "Min post id is: " . min(array_keys($languageCodeArray)) . PHP_EOL;
echo "Max post id is: " . max(array_keys($languageCodeArray)) . PHP_EOL;
echo PHP_EOL;


// Get new WP URLs:
$postIdToWpUrlsArray = array();
$nodeIdToWpUrlsArray = array();

$sql = "SELECT `ID` AS `postId`, YEAR(`post_date`) AS `year`,`post_name` AS `postName` 
        FROM `wp_posts` 
        WHERE `post_type` IN ('post','page','issue');";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['postId'])) {
        continue;
    }
    if (empty($row['year'])) {
        continue;
    }
    if (empty($row['postName'])) {
        continue;
    }
    if (array_key_exists($row['postId'], $languageCodeArray)) {
        $wpUrl = '/' . $row['year'];
        $lang = $languageCodeArray[$row['postId']];
        if ($lang != 'en') {
            $wpUrl .= '/' . $languageCodeArray[$row['postId']];
        }
        $wpUrl .= '/' . $row['postName'];

        // Only add new WP URL, if node id exists for post id
        if (array_key_exists($row['postId'], $mapPostIdToNodeIdArray)) {
            // Get node id for post id
            $currentNodeId = $mapPostIdToNodeIdArray[$row['postId']];
            $nodeIdToWpUrlsArray[$currentNodeId] = $wpUrl;
            $postIdToWpUrlsArray[$row['postId']] = $wpUrl;
        }

    } else {
        echo "ERROR:";
        echo $row['postId'];
        echo PHP_EOL;
    }
}

echo "Array postIdToWpUrlsArray has " . count($postIdToWpUrlsArray) . " entries" . PHP_EOL;
echo "Min post id is: " . min(array_keys($postIdToWpUrlsArray)) . PHP_EOL;
echo "Max post id is: " . max(array_keys($postIdToWpUrlsArray)) . PHP_EOL;
echo PHP_EOL;

echo "Array nodeIdToWpUrlsArray has " . count($nodeIdToWpUrlsArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($nodeIdToWpUrlsArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($nodeIdToWpUrlsArray)) . PHP_EOL;
echo PHP_EOL;

$statement->close();


// Final redirection array: old url => WP url
$finalRedirectionArray = array();

// Add node id URLs
foreach ($nodeIdUrlArray as $nodeId => $nodeUrl) {
    if (empty($nodeId)) {
        continue;
    }
    if (empty($nodeUrl)) {
        continue;
    }

    $finalRedirectionArray[$nodeUrl] = $nodeIdToWpUrlsArray[$nodeId];
}

echo "Array finalRedirectionArray has " . count($finalRedirectionArray) . " entries" . PHP_EOL;
echo "Min key is: " . min(array_keys($finalRedirectionArray)) . PHP_EOL;
echo "Max key is: " . max(array_keys($finalRedirectionArray)) . PHP_EOL;
echo PHP_EOL;


// Add URL aliases
foreach ($urlAliasArray as $nodeId => $nodeUrl) {
    if (empty($nodeId)) {
        continue;
    }
    if (empty($nodeUrl)) {
        continue;
    }
    $finalRedirectionArray[$nodeUrl] = $nodeIdToWpUrlsArray[$nodeId];
}

echo "Array finalRedirectionArray has " . count($finalRedirectionArray) . " entries" . PHP_EOL;
echo "Min key is: " . min(array_keys($finalRedirectionArray)) . PHP_EOL;
echo "Max key is: " . max(array_keys($finalRedirectionArray)) . PHP_EOL;
echo PHP_EOL;


// Add redirects
foreach ($redirectsArray as $source => $url) {
    if (empty($source)) {
        continue;
    }
    if (empty($url)) {
        continue;
    }
    $finalRedirectionArray[$source] = $url;
}

echo "Array finalRedirectionArray has " . count($finalRedirectionArray) . " entries" . PHP_EOL;
echo "Min key is: " . min(array_keys($finalRedirectionArray)) . PHP_EOL;
echo "Max key is: " . max(array_keys($finalRedirectionArray)) . PHP_EOL;
echo PHP_EOL;

die();
// Insert into database table

// Prepared Statements for inserting data
$sql = "INSERT INTO `wp_redirection_items` (`id`, `url`, `match_url`, `match_data`, `regex`, `position`, `last_count`, 
    `last_access`, `group_id`, `status`, `action_type`, `action_code`, `action_data`, `match_type`, `title`) 
    VALUES (NULL, ?, ?, '{\"source\":{\"flag_query\":\"pass\"}}', '0', '0', '0', '1970-01-01 00:00:00.000000', 
    '1', 'enabled', 'url', '301', ?, 'url', NULL);";
$stmt = $conn->prepare($sql);
$source = '';
$target = '';
$stmt->bind_param("sss", $source, $source, $target);

foreach ($finalRedirectionArray as $currentSource => $currentTarget) {
    if (substr($currentSource, 0, 1) != '/') {
        $currentSource = '/' . $currentSource;
    }
    if (substr($currentTarget, 0, 1) != '/') {
        $currentTarget = '/' . $currentTarget;
    }
    $source = $currentSource;
    $target = $currentTarget;
    $stmt->execute();
}

echo "All redirect have been added" . PHP_EOL;

$stmt->close();


// close connection to WP database
$conn->close();
