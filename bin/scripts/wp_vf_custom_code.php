<?php
/*
 * Script for custom queries to update wordpress configurations
 *
 */

/** Make sure that the WordPress bootstrap has run before continuing. */
echo dirname(__FILE__);
if (php_sapi_name() === "cli") {
  $ROOT_PATH=trim($argv[1]);
  $ENV=trim($argv[2]);
}
echo " ==Params== " . $ROOT_PATH . " ==== " . $ENV;

if ( empty($ROOT_PATH) || empty($ENV) ) {
  echo "Missing the required parameters of path & env, aborting the script";
  return '';
}

require($ROOT_PATH . '/wp-load.php');

if ($ENV == 'dev' || $ENV == 'stage') {
  // Dev/Test SAML Endpoint
  $SAML_IDP_PATH = 'https://idp-test.embl.de';
}
else {
  // Production SAML Endpoint
  $SAML_IDP_PATH = 'https://idp.embl.de';
}

$time_start = microtime(true);

// WP update SAML options values
update_option( 'onelogin_saml_enabled', 'on');
update_option( 'onelogin_saml_idp_entityid', $SAML_IDP_PATH . '/simplesaml/saml2/idp/metadata.php');
update_option( 'onelogin_saml_idp_sso', $SAML_IDP_PATH . '/simplesaml/saml2/idp/SSOService.php');
update_option( 'onelogin_saml_idp_slo', $SAML_IDP_PATH . '/simplesaml/saml2/idp/SingleLogoutService.php');
update_option( 'onelogin_saml_idp_x509cert', 'MIIEBTCCAu2gAwIBAgIJANrwstaqr/RtMA0GCSqGSIb3DQEBCwUAMIGYMQswCQYDVQQGEwJERTEdMBsGA1UECAwUQmFkZW4tV8ODdWVydHRlbWJlcmcxEzARBgNVBAcMCkhlaWRlbGJlcmcxDTALBgNVBAoMBEVNQkwxFDASBgNVBAsMC0lUIFNlcnZpY2VzMRQwEgYDVQQDDAtpZHAuZW1ibC5kZTEaMBgGCSqGSIb3DQEJARYLaXRzLmVtYmwuZGUwHhcNMTUwODEwMTMwNjA5WhcNMjUwODA5MTMwNjA5WjCBmDELMAkGA1UEBhMCREUxHTAbBgNVBAgMFEJhZGVuLVfDg3VlcnR0ZW1iZXJnMRMwEQYDVQQHDApIZWlkZWxiZXJnMQ0wCwYDVQQKDARFTUJMMRQwEgYDVQQLDAtJVCBTZXJ2aWNlczEUMBIGA1UEAwwLaWRwLmVtYmwuZGUxGjAYBgkqhkiG9w0BCQEWC2l0cy5lbWJsLmRlMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAohEeM2W6pQo8g4BGbUdBIxK7+Wx5DmfK7prHr/jrcFj9TwlpZ/wnI1eUOigRoQc3cSezPoAY2M5ut8SnIfQzQB89qluCtHiS0zX3Ekv8otnYHHInmmS5HqHmRjKa15C25CPp64WgAPPdDEps2RjbiYI0kcRUJxSEwNm7HrZBmyWaPG5PwMvJinh+ZqJTGPxeYYORkP99KWDEBM7b/7gYpKWcJlITzqz/0t4NNKtb8L8jm+komK6GzCH6QJACWtBtoybLVREgCIEo+RPflAG9LYWhTr8wBx1GeWnIeJ7eeeHIMw6bErwzcp23rcS26/kvBaRrFzimT59WlN3AKz8jkwIDAQABo1AwTjAdBgNVHQ4EFgQUMaXasbeE3nWSKM4taWMt8wJ7jjswHwYDVR0jBBgwFoAUMaXasbeE3nWSKM4taWMt8wJ7jjswDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAPjFfSf1uKZ7LlzkpY4MD+B8x+vvyWJVeejNDoSBKnIhfSQEe7G4yUyv7SiwmivqkUo/qq0Jqd2BeN269HHV+wsI3y7SBsNHEWWBmCAiUuxgkJzCTP2Vg3T9Wjm9aFroZrasELzOmsdaqTnsUcx4L/w1GjYMEYB0P15nYTHahMmx2Oag1IR0pMbQ//PSuUEFBJ7EfVg0PY4Bb3/NUa+MYOQgZEvbVKn2cFA64RgWsDKbYD4TkMnBefa5kB+9TKwA35Gs7JDSuVblqVlcVrEVXKK42ziCNJE7aIED0tonCwA6equoY0Kv5ADOk5d6k0nwmdECFh54LZZDB+Jzf7eguxw==');
update_option( 'onelogin_saml_autocreate', 'on');
update_option( 'onelogin_saml_updateuser', 'on');
update_option( 'onelogin_saml_forcelogin', '');
update_option( 'onelogin_saml_slo', 'on');
update_option( 'onelogin_saml_keep_local_login', '');
update_option( 'onelogin_saml_account_matcher', 'email');
update_option( 'onelogin_saml_alternative_acs', '');
update_option( 'onelogin_saml_attr_mapping_username', 'mail');
update_option( 'onelogin_saml_attr_mapping_mail', 'mail');
update_option( 'onelogin_saml_attr_mapping_firstname', 'cn');
update_option( 'onelogin_saml_attr_mapping_lastname', '');
update_option( 'onelogin_saml_attr_mapping_role', '');
update_option( 'onelogin_saml_attr_mapping_rememberme', '');
update_option( 'onelogin_saml_role_mapping_administrator', '');
update_option( 'onelogin_saml_role_mapping_editor', '');
update_option( 'onelogin_saml_role_mapping_author', '');
update_option( 'onelogin_saml_role_mapping_contributor', '');
update_option( 'onelogin_saml_role_mapping_subscriber', '');
update_option( 'onelogin_saml_role_mapping_multivalued_in_one_attribute_value', '');
update_option( 'onelogin_saml_role_mapping_multivalued_pattern', '');
update_option( 'onelogin_saml_role_order_administrator', '');
update_option( 'onelogin_saml_role_order_editor', '');
update_option( 'onelogin_saml_role_order_author', '');
update_option( 'onelogin_saml_role_order_contributor', '');
update_option( 'onelogin_saml_role_order_subscriber', '');
update_option( 'onelogin_saml_customize_action_prevent_local_login', '');
update_option( 'onelogin_saml_customize_action_prevent_reset_password', 'on');
update_option( 'onelogin_saml_customize_action_prevent_change_password', 'on');
update_option( 'onelogin_saml_customize_action_prevent_change_mail', 'on');
update_option( 'onelogin_saml_customize_stay_in_wordpress_after_slo', '');
update_option( 'onelogin_saml_customize_links_user_registration', '');
update_option( 'onelogin_saml_customize_links_lost_password', '');
update_option( 'onelogin_saml_customize_links_saml_login', '');
update_option( 'onelogin_saml_advanced_settings_debug', '');
update_option( 'onelogin_saml_advanced_settings_strict_mode', '');
update_option( 'onelogin_saml_advanced_idp_lowercase_url_encoding', '');
update_option( 'onelogin_saml_advanced_settings_nameid_encrypted', '');
update_option( 'onelogin_saml_advanced_settings_authn_request_signed', '');
update_option( 'onelogin_saml_advanced_settings_logout_request_signed', '');
update_option( 'onelogin_saml_advanced_settings_logout_response_signed', '');
update_option( 'onelogin_saml_advanced_settings_want_message_signed', '');
update_option( 'onelogin_saml_advanced_settings_want_assertion_signed', '');
update_option( 'onelogin_saml_advanced_settings_want_assertion_encrypted', '');
update_option( 'onelogin_saml_advanced_settings_retrieve_parameters_from_server', '');
update_option( 'onelogin_saml_advanced_nameidformat', 'persistent');
update_option( 'onelogin_saml_advanced_requestedauthncontext', '');
update_option( 'onelogin_saml_advanced_settings_sp_x509cert', 'MIICUjCCAbugAwIBAgIJAJDgIp9KXqF+MA0GCSqGSIb3DQEBCwUAMEIxCzAJBgNVBAYTAlVLMRUwEwYDVQQHDAxEZWZhdWx0IENpdHkxHDAaBgNVBAoME0RlZmF1bHQgQ29tcGFueSBMdGQwHhcNMTkwNjEwMTUyNjExWhcNMjQwNjA4MTUyNjExWjBCMQswCQYDVQQGEwJVSzEVMBMGA1UEBwwMRGVmYXVsdCBDaXR5MRwwGgYDVQQKDBNEZWZhdWx0IENvbXBhbnkgTHRkMIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBknF7q0Nz0F0qXddIrrjczEx4zqXmE75l7UojGt4x7MWJdqHhCZe9cMb2qlXHWKPJONVtfNEOtMSEnXpe9RAQMW2AmPK5THOjKe6+qaOGuHdzvAvLiatxLrTjL4mxt4fs0uSX4aixICm5QdNBccNJy4yVRQn65c8Fva8s55ZfAwIDAQABo1AwTjAdBgNVHQ4EFgQUGhlpKliBoBZ7xyQtlkxJUr/t/Z8wHwYDVR0jBBgwFoAUGhlpKliBoBZ7xyQtlkxJUr/t/Z8wDAYDVR0TBAUwAwEB/zANBgkqhkiG9w0BAQsFAAOBgQCqzMr7uiKlHoJ9OZMwvsO8jSFl68JGoO67ATMaleLcPbz4Me7OFEXE135ryyT152RzgujZl75eGeNyHCQ+0/DhhTlHMcLOtnFjHp6/RLgQG7fnLs9r/twfO76OdrBGe8urLyRJh9r5ADK/2CGdAMiJ9PQ3vV2ghoVNMdOmrFLRZg==');
update_option( 'onelogin_saml_advanced_settings_sp_privatekey', 'MIICXAIBAAKBgQDBknF7q0Nz0F0qXddIrrjczEx4zqXmE75l7UojGt4x7MWJdqHhCZe9cMb2qlXHWKPJONVtfNEOtMSEnXpe9RAQMW2AmPK5THOjKe6+qaOGuHdzvAvLiatxLrTjL4mxt4fs0uSX4aixICm5QdNBccNJy4yVRQn65c8Fva8s55ZfAwIDAQABAoGBAIHqWHHo6veCw9SYcNHeOkIud7Co+N0nKSVdkeFnufMF9zogPds8RfQmCdMpVTLawepeU5gNKn5VQoPC8YtjrGgXBORXmaLe1cOaoJEajIxUUUD0p0laTahQZiJE2AdALSLLU6eYZ9JESEFvY9164sVFQw3erUU2sxn89K4tRO9ZAkEA3rZjUiLE7jnEJDNBgBzSP6oY42AbqhW0Z4XgoLVG1/gO8wu4LFIMT/r4Udscemkb8r4l1aiT4kHpHoKnLZU9pQJBAN6BD3TofVlH8pZnO2BOwCdbcOTJbZKLFrd9Z1uF9IxR2ODFG+lrsn7uGV1/TRGQmMNea2u1BvVBS1iB5Ex62YcCQCIGAw5dOXCbapeNLQiBXq1TMxIpcJB/WFwoW7SxfO0pfD8tHynGLxNY5+65ZpRc0mQ3IFiPtGfwYcjDdP7FufECQDqWz2QgaAlfaaBzFG56rhxu9p438BNbbqLocZPnBQsB7lLZdE0Vn83Okn1NLRUH90HSlgSpiWiBRf7LTTtaSfcCQAbfjp4nch5FVa3ft7VuQqagSMy+8ZvdbnjNxPXWe5pnRJeo614/W17mOeLAzyiFv/pxw5jfuH79VKat/47r2s8=');
update_option( 'onelogin_saml_advanced_signaturealgorithm', 'http://www.w3.org/2000/09/xmldsig#rsa-sha1');
update_option( 'onelogin_saml_advanced_digestalgorithm', 'http://www.w3.org/2000/09/xmldsig#sha1');


echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
