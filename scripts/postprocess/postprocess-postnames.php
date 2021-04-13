<?php
// Script for postprocessing postnames for articles


include "./include-postprocess.php";

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

// First: Get all English translations
$mapTridToPostName = array();

$sql = "SELECT `element_id`, `trid`, `post_name`  
    FROM `wp_icl_translations` JOIN `wp_posts` ON `element_id` = `ID` 
        WHERE `element_type` = 'post_sis-article' and `language_code` = 'en';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['element_id'])) {
        echo "Error: Empty element_id " . PHP_EOL;
        continue;
    }
    if (empty($row['trid'])) {
        echo "Error: Empty trid " . PHP_EOL;
        continue;
    }
    if (empty($row['post_name'])) {
        echo "Error: Empty post_name " . PHP_EOL;
        continue;
    }

    $postName = $row['post_name'];
    $postNameLength = strlen($postName);
    $cleanPostName = $postName;
    if(preg_match("/.*-\d$/",$postName )){
        $cleanPostName = substr($postName, 0, $postNameLength -2);
    }
    $mapTridToPostName[ $row['trid'] ] = $cleanPostName;
}
$statement->close();

echo "Array mapTridToPostName has " . count($mapTridToPostName) . " entries" . PHP_EOL;
echo "Min trid_id is: " . min(array_keys($mapTridToPostName)) . PHP_EOL;
echo "Max trid is: " . max(array_keys($mapTridToPostName)) . PHP_EOL;
echo PHP_EOL;



// Second get all translations
$mapPostIdToPostName = array();

$sql = "SELECT `element_id`, `trid` FROM `wp_icl_translations`  WHERE `element_type` = 'post_sis-article';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['element_id'])) {
        echo "Error: Empty element_id " . PHP_EOL;
        continue;
    }
    if (empty($row['trid'])) {
        echo "Error: Empty trid " . PHP_EOL;
        continue;
    }

    if(!array_key_exists($row['trid'], $mapTridToPostName)){
        continue;
    }

    $postName = $mapTridToPostName[ $row['trid'] ];
    $mapPostIdToPostName[$row['element_id']] = $postName;
}
$statement->close();

echo "Array mapPostIdToPostName has " . count($mapPostIdToPostName) . " entries" . PHP_EOL;
echo "Min post_id is: " . min(array_keys($mapPostIdToPostName)) . PHP_EOL;
echo "Max post_id is: " . max(array_keys($mapPostIdToPostName)) . PHP_EOL;
echo PHP_EOL;


// Update database table

// Prepared Statements for updating data
$sql = "UPDATE `wp_posts` SET `post_name` = ? WHERE `ID` = ? ;";
$stmt = $conn->prepare($sql);
$postName = '';
$postId = 0;
$stmt->bind_param("si", $postName, $postId);

foreach ($mapPostIdToPostName as $currentPostId => $currentPostName) {
    if(empty($currentPostId) || empty($currentPostName)){
        echo "ERROR: Empty currentPostId or currentPostName " . PHP_EOL;
        continue;
    }
    $postName = $currentPostName;
    $postId = $currentPostId;
    $stmt->execute();
}

$stmt->close();


echo "All postnames for all articles have been processed." . PHP_EOL;



// close connection to WP database
$conn->close();
