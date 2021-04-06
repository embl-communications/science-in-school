<?php
// Script for postprocessing images and files

// SELECT * FROM `wp_term_relationships` WHERE `object_id` IN (SELECT `ID` FROM `wp_posts` WHERE `post_type` = 'sis-article')

//  post_parent = postId
// post_type = 'attachment'
// guid

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
        echo "Error: Empty nid " . PHP_EOL;
        continue;
    }
    if (empty($row['url'])) {
        echo "Error: Empty url " . PHP_EOL;
        continue;
    }
    $nodeIdUrlArray[$row['nid']] = $row['url'];
}
$statement->close();

echo "Array nodeIdUrlArray has " . count($nodeIdUrlArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($nodeIdUrlArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($nodeIdUrlArray)) . PHP_EOL;
echo PHP_EOL;



echo "All images and files have been added" . PHP_EOL;



// close connection to WP database
$conn->close();
