#!/bin/bash
##################################################
# Script for SAML configurations for microsites  #
#################################################

# determine root of repo
ROOT=$(cd $(dirname ${0})/../.. 2>/dev/null && pwd -P);
# set environment variables
set -a; source ${ROOT}/.env; set +a;

# Set alias for wp command
alias wp="~/bin/wp";
shopt -s expand_aliases

# Site path
DEPLOY_PATH=${1: }
cd ${DEPLOY_PATH}/

wp option set onelogin_saml_enabled 1;
wp option set onelogin_saml_idp_entityid 'https://idp.embl.de/simplesaml/saml2/idp/metadata.php';
wp option set onelogin_saml_idp_sso 'https://idp.embl.de/simplesaml/saml2/idp/SSOService.php';
wp option set onelogin_saml_idp_slo 'https://idp.embl.de/simplesaml/saml2/idp/SingleLogoutService.php';
wp option set onelogin_saml_idp_x509cert 'MIIEBTCCAu2gAwIBAgIJANrwstaqr/RtMA0GCSqGSIb3DQEBCwUAMIGYMQswCQYDVQQGEwJERTEdMBsGA1UECAwUQmFkZW4tV8ODdWVydHRlbWJlcmcxEzARBgNVBAcMCkhlaWRlbGJlcmcxDTALBgNVBAoMBEVNQkwxFDASBgNVBAsMC0lUIFNlcnZpY2VzMRQwEgYDVQQDDAtpZHAuZW1ibC5kZTEaMBgGCSqGSIb3DQEJARYLaXRzLmVtYmwuZGUwHhcNMTUwODEwMTMwNjA5WhcNMjUwODA5MTMwNjA5WjCBmDELMAkGA1UEBhMCREUxHTAbBgNVBAgMFEJhZGVuLVfDg3VlcnR0ZW1iZXJnMRMwEQYDVQQHDApIZWlkZWxiZXJnMQ0wCwYDVQQKDARFTUJMMRQwEgYDVQQLDAtJVCBTZXJ2aWNlczEUMBIGA1UEAwwLaWRwLmVtYmwuZGUxGjAYBgkqhkiG9w0BCQEWC2l0cy5lbWJsLmRlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAohEeM2W6pQo8g4BGbUdBIxK7+Wx5DmfK7prHr/jrcFj9TwlpZ/wnI1eUOigRoQc3cSezPoAY2M5ut8SnIfQzQB89qluCtHiS0zX3Ekv8otnYHHInmmS5HqHmRjKa15C25CPp64WgAPPdDEps2RjbiYI0kcRUJxSEwNm7HrZBmyWaPG5PwMvJinh+ZqJTGPxeYYORkP99KWDEBM7b/7gYpKWcJlITzqz/0t4NNKtb8L8jm+komK6GzCH6QJACWtBtoybLVREgCIEo+RPflAG9LYWhTr8wBx1GeWnIeJ7eeeHIMw6bErwzcp23rcS26/kvBaRrFzimT59WlN3AKz8jkwIDAQABo1AwTjAdBgNVHQ4EFgQUMaXasbeE3nWSKM4taWMt8wJ7jjswHwYDVR0jBBgwFoAUMaXasbeE3nWSKM4taWMt8wJ7jjswDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAPjFfSf1uKZ7LlzkpY4MD+B8x+vvyWJVeejNDoSBKnIhfSQEe7G4yUyv7SiwmivqkUo/qq0Jqd2BeN269HHV+wsI3y7SBsNHEWWBmCAiUuxgkJzCTP2Vg3T9Wjm9aFroZrasELzOmsdaqTnsUcx4L/w1GjYMEYB0P15nYTHahMmx2Oag1IR0pMbQ//PSuUEFBJ7EfVg0PY4Bb3/NUa+MYOQgZEvbVKn2cFA64RgWsDKbYD4TkMnBefa5kB+9TKwA35Gs7JDSuVblqVlcVrEVXKK42ziCNJE7aIED0tonCwA6equoY0Kv5ADOk5d6k0nwmdECFh54LZZDB+Jzf7eguxw==';
wp option set onelogin_saml_autocreate 1;
wp option set onelogin_saml_updateuser 1;
wp option set onelogin_saml_forcelogin 0;
wp option set onelogin_saml_slo 1;
wp option set onelogin_saml_keep_local_login 0;
wp option set onelogin_saml_account_matcher 'email';
wp option set onelogin_saml_alternative_acs 0;
wp option set onelogin_saml_attr_mapping_username 'mail';
wp option set onelogin_saml_attr_mapping_mail 'mail';
wp option set onelogin_saml_attr_mapping_firstname 'cn';
wp option set onelogin_saml_attr_mapping_lastname '';
wp option set onelogin_saml_attr_mapping_role '';
wp option set onelogin_saml_attr_mapping_rememberme '';
wp option set onelogin_saml_role_mapping_administrator '';
wp option set onelogin_saml_role_mapping_editor '';
wp option set onelogin_saml_role_mapping_author '';
wp option set onelogin_saml_role_mapping_contributor '';
wp option set onelogin_saml_role_mapping_subscriber '';
wp option set onelogin_saml_role_mapping_multivalued_in_one_attribute_value 0;
wp option set onelogin_saml_role_mapping_multivalued_pattern '';
wp option set onelogin_saml_role_order_administrator '';
wp option set onelogin_saml_role_order_editor '';
wp option set onelogin_saml_role_order_author '';
wp option set onelogin_saml_role_order_contributor '';
wp option set onelogin_saml_role_order_subscriber '';
wp option set onelogin_saml_customize_action_prevent_local_login 0;
wp option set onelogin_saml_customize_action_prevent_reset_password 1;
wp option set onelogin_saml_customize_action_prevent_change_password 1;
wp option set onelogin_saml_customize_action_prevent_change_mail 1;
wp option set onelogin_saml_customize_stay_in_wordpress_after_slo 0;
wp option set onelogin_saml_customize_links_user_registration '';
wp option set onelogin_saml_customize_links_lost_password '';
wp option set onelogin_saml_customize_links_saml_login '';
wp option set onelogin_saml_advanced_settings_debug 0;
wp option set onelogin_saml_advanced_settings_strict_mode 0;
wp option set onelogin_saml_advanced_idp_lowercase_url_encoding 0;
wp option set onelogin_saml_advanced_settings_nameid_encrypted 0;
wp option set onelogin_saml_advanced_settings_authn_request_signed 0;
wp option set onelogin_saml_advanced_settings_logout_request_signed 0;
wp option set onelogin_saml_advanced_settings_logout_response_signed 0;
wp option set onelogin_saml_advanced_settings_want_message_signed 0;
wp option set onelogin_saml_advanced_settings_want_assertion_signed 0;
wp option set onelogin_saml_advanced_settings_want_assertion_encrypted 0;
wp option set onelogin_saml_advanced_settings_retrieve_parameters_from_server 0;
wp option set onelogin_saml_advanced_nameidformat 'persistent';
wp option set onelogin_saml_advanced_requestedauthncontext '';
wp option set onelogin_saml_advanced_settings_sp_x509cert 'MIICUjCCAbugAwIBAgIJAJDgIp9KXqF+MA0GCSqGSIb3DQEBCwUAMEIxCzAJBgNVBAYTAlVLMRUwEwYDVQQHDAxEZWZhdWx0IENpdHkxHDAaBgNVBAoME0RlZmF1bHQgQ29tcGFueSBMdGQwHhcNMTkwNjEwMTUyNjExWhcNMjQwNjA4MTUyNjExWjBCMQswCQYDVQQGEwJVSzEVMBMGA1UEBwwMRGVmYXVsdCBDaXR5MRwwGgYDVQQKDBNEZWZhdWx0IENvbXBhbnkgTHRkMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBknF7q0Nz0F0qXddIrrjczEx4zqXmE75l7UojGt4x7MWJdqHhCZe9cMb2qlXHWKPJONVtfNEOtMSEnXpe9RAQMW2AmPK5THOjKe6+qaOGuHdzvAvLiatxLrTjL4mxt4fs0uSX4aixICm5QdNBccNJy4yVRQn65c8Fva8s55ZfAwIDAQABo1AwTjAdBgNVHQ4EFgQUGhlpKliBoBZ7xyQtlkxJUr/t/Z8wHwYDVR0jBBgwFoAUGhlpKliBoBZ7xyQtlkxJUr/t/Z8wDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOBgQCqzMr7uiKlHoJ9OZMwvsO8jSFl68JGoO67ATMaleLcPbz4Me7OFEXE135ryyT152RzgujZl75eGeNyHCQ+0/DhhTlHMcLOtnFjHp6/RLgQG7fnLs9r/twfO76OdrBGe8urLyRJh9r5ADK/2CGdAMiJ9PQ3vV2ghoVNMdOmrFLRZg==';
wp option set onelogin_saml_advanced_settings_sp_privatekey 'MIICXAIBAAKBgQDBknF7q0Nz0F0qXddIrrjczEx4zqXmE75l7UojGt4x7MWJdqHhCZe9cMb2qlXHWKPJONVtfNEOtMSEnXpe9RAQMW2AmPK5THOjKe6+qaOGuHdzvAvLiatxLrTjL4mxt4fs0uSX4aixICm5QdNBccNJy4yVRQn65c8Fva8s55ZfAwIDAQABAoGBAIHqWHHo6veCw9SYcNHeOkIud7Co+N0nKSVdkeFnufMF9zogPds8RfQmCdMpVTLawepeU5gNKn5VQoPC8YtjrGgXBORXmaLe1cOaoJEajIxUUUD0p0laTahQZiJE2AdALSLLU6eYZ9JESEFvY9164sVFQw3erUU2sxn89K4tRO9ZAkEA3rZjUiLE7jnEJDNBgBzSP6oY42AbqhW0Z4XgoLVG1/gO8wu4LFIMT/r4Udscemkb8r4l1aiT4kHpHoKnLZU9pQJBAN6BD3TofVlH8pZnO2BOwCdbcOTJbZKLFrd9Z1uF9IxR2ODFG+lrsn7uGV1/TRGQmMNea2u1BvVBS1iB5Ex62YcCQCIGAw5dOXCbapeNLQiBXq1TMxIpcJB/WFwoW7SxfO0pfD8tHynGLxNY5+65ZpRc0mQ3IFiPtGfwYcjDdP7FufECQDqWz2QgaAlfaaBzFG56rhxu9p438BNbbqLocZPnBQsB7lLZdE0Vn83Okn1NLRUH90HSlgSpiWiBRf7LTTtaSfcCQAbfjp4nch5FVa3ft7VuQqagSMy+8ZvdbnjNxPXWe5pnRJeo614/W17mOeLAzyiFv/pxw5jfuH79VKat/47r2s8=';
wp option set onelogin_saml_advanced_signaturealgorithm 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
wp option set onelogin_saml_advanced_digestalgorithm 'http://www.w3.org/2000/09/xmldsig#sha1';
