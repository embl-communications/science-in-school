<?php
// Script for postprocessing materials attachted to articles


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

// First: Create array with mapping of guid to post id
$guidToPostIdMappingArray = array();

$sql = "SELECT `ID`, `guid` FROM `wp_posts` WHERE `post_type` = 'attachment';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['ID'])) {
        echo "Error: Empty ID " . PHP_EOL;
        continue;
    }
    if (empty($row['guid'])) {
        echo "Error: Empty guid " . PHP_EOL;
        continue;
    }
    $guidToPostIdMappingArray[$row['guid']] = $row['ID'];
}
$statement->close();

echo "Array guidToPostIdMappingArray has " . count($guidToPostIdMappingArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($guidToPostIdMappingArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($guidToPostIdMappingArray)) . PHP_EOL;
echo PHP_EOL;



// Secondly: Get all materials of all articles
$numberOfMaterialsForPostIdArray = array();
$metaIdToMetaValueArray = array();
$metaIdToMetaKeyArray = array();

$sql = "SELECT `meta_id`, `meta_value`, `post_id`  FROM `wp_postmeta` WHERE `meta_key` LIKE 'wpcf-materials';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['meta_id'])) {
        echo "Error: Empty meta_id " . PHP_EOL;
        continue;
    }
    if (empty($row['meta_value'])) {
        echo "Error: Empty meta_value " . PHP_EOL;
        continue;
    }
    if (empty($row['post_id'])) {
        echo "Error: Empty post_id " . PHP_EOL;
        continue;
    }

    $metaId = $row['meta_id'];
    $metaValue = $row['meta_value'];
    $postId = $row['post_id'];

    if(array_key_exists($postId, $numberOfMaterialsForPostIdArray)){
        $number = $numberOfMaterialsForPostIdArray[$postId];
        $number++;
        $numberOfMaterialsForPostIdArray[$postId] = $number;
    } else {
        $numberOfMaterialsForPostIdArray[$postId] = 0;
    }

    $metaIdToMetaValueArray[$metaId] = $guidToPostIdMappingArray[$metaValue];
    $metaIdToMetaKeyArray[$metaId] = 'art_materials_' . $numberOfMaterialsForPostIdArray[$postId] . '_art_single_material';
}
$statement->close();



// Update database table

// Prepared Statements for updating data
$sql = "UPDATE `wp_postmeta` SET `meta_value`=?, `meta_key`=? WHERE `meta_id`=?;";
$stmt = $conn->prepare($sql);
$metaValue = '';
$metaKey = '';
$metaId = 0;
$stmt->bind_param("ssi", $metaValue, $metaKey, $metaId);

foreach ($metaIdToMetaValueArray as $currentMetaId => $currentMetaValue) {
    if(empty($currentMetaId) || empty($currentMetaValue)){
        echo "ERROR: Empty currentMetaId or currentMetaValue " . PHP_EOL;
        continue;
    }
    $metaValue = $currentMetaValue;
    $metaId = $currentMetaId;
    $metaKey = $metaIdToMetaKeyArray[$currentMetaId];

    $stmt->execute();
}
$stmt->close();


// Add number of materials using another prepared statement
$sql = "INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) 
    VALUES (?, ?, ?);";
$stmt = $conn->prepare($sql);
$postId = 0;
$metaKey = '';
$metaValue = '';
$stmt->bind_param("iss", $postId, $metaKey, $metaValue);

foreach ($numberOfMaterialsForPostIdArray as $currentPostId => $currentNumber) {
    if(empty($currentPostId)){
        echo "ERROR: Empty currentPostId " . PHP_EOL;
        continue;
    }

    $postId = $currentPostId;
    $metaKey = 'art_materials';
    $currentNumber++;
    $metaValue = $currentNumber;
    $stmt->execute();
}
$stmt->close();



echo "All materials have been added" . PHP_EOL;



// close connection to WP database
$conn->close();
