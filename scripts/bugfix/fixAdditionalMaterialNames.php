<?php
// Script for fixing and adding the filenames of the additional material


include "../postprocess/include-postprocess.php";

// DB user and password should be passed as arguments
if (!isset($argc) || $argc < 3) {
    die("Too few arguments: php postprocess-urls.php dbuser dbpass");
}
$userName = $argv[1];
$password = $argv[2];


///////// PART A: Drupal
// create connection to Drupal
$conn = mysqli_connect($serverName, $userName, $password, $dbNameDrupal);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// First: Get names of additional material from drupal
$fileNamesAdditionaMaterialArray = array();

$sql = "SELECT `entity_id`, `delta`, `field_materials_description` FROM `field_data_field_materials` WHERE `deleted` = 0;";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['entity_id'])) {
        echo "Error: entity_id " . PHP_EOL;
        continue;
    }

    if(!array_key_exists($row['entity_id'], $fileNamesAdditionaMaterialArray)){
        $fileNamesAdditionaMaterialArray[$row['entity_id']] = array();
    }
    $fileNamesAdditionaMaterialArray[$row['entity_id']][$row['delta']] = $row['field_materials_description'];
}
$statement->close();

echo "Array fileNamesAdditionaMaterialArray has " . count($fileNamesAdditionaMaterialArray) . " entries" . PHP_EOL;
echo "Min node id is: " . min(array_keys($fileNamesAdditionaMaterialArray)) . PHP_EOL;
echo "Max node id is: " . max(array_keys($fileNamesAdditionaMaterialArray)) . PHP_EOL;
echo PHP_EOL;

// close connection to drupal
$conn->close();


///////// PART B: Wordpress
// create connection to WP
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1.: Get post ids and their meta_key for of articles, which have additional material files
$postIdsAndMetaKeyEnglishArticlesArray = array();

$sql = "SELECT `post_id`, `meta_key` FROM `wp_postmeta` WHERE `meta_key` LIKE ('art_materials_%_art_single_material');";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['post_id'])) {
        echo "Error: post_id " . PHP_EOL;
        continue;
    }
    if (empty($row['meta_key'])) {
        echo "Error: meta_key " . PHP_EOL;
        continue;
    }
    $postIdsAndMetaKeyEnglishArticlesArray[$row['post_id']] = $row['meta_key'];
}
$statement->close();

echo "Array postIdsAndMetaKeyEnglishArticlesArray has " . count($postIdsAndMetaKeyEnglishArticlesArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($postIdsAndMetaKeyEnglishArticlesArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($postIdsAndMetaKeyEnglishArticlesArray)) . PHP_EOL;
echo PHP_EOL;


// 2.:Mapping between node ids and WP post ids
$mapNodeIdToPostIdArray = array();
$mapPostIdToNodeIdArray = array();

$sql = "SELECT `post_id` AS `postId`, `meta_value` AS `nodeId` FROM `wp_postmeta` WHERE `meta_key` = '_fgd2wp_old_node_id';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['nodeId'])) {
        echo "Error: Empty nodeId " . PHP_EOL;
        continue;
    }
    if (empty($row['postId'])) {
        echo "Error: Empty postId " . PHP_EOL;
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


// 3.: Delete old material names
$sql = "DELETE FROM `wp_postmeta` WHERE `meta_key` LIKE ('art_materials_%_art_single_name');";
$statement = $conn->prepare($sql);
$statement->execute();
$statement->close();


// 4.: Add entries for additional material names
$sql = "INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) 
    VALUES (?, ?, ?);";
$stmt = $conn->prepare($sql);
$postId = 0;
$metaKey = '';
$metaValue = '';
$stmt->bind_param("iss", $postId, $metaKey, $metaValue);
$addedMaterials = 0;

foreach ($fileNamesAdditionaMaterialArray as $currentNodeId => $currentEntriesArray) {
    if(empty($currentNodeId)){
        echo "ERROR: Empty currentNodeId " . PHP_EOL;
        continue;
    }

    foreach($currentEntriesArray as $currentDelta => $currentFileName){
        if(!array_key_exists($currentNodeId, $mapNodeIdToPostIdArray)){
            continue;
        }
        $currentPostId = $mapNodeIdToPostIdArray[$currentNodeId];

        if(empty($currentPostId)){
            continue;
        }


        $postId = $currentPostId;
        $metaKey = 'art_materials_' . $currentDelta . '_art_single_name';
        $metaValue = $currentFileName;
        $stmt->execute();
        $addedMaterials++;
    }
}
$stmt->close();
echo "Added material names: " . $addedMaterials . PHP_EOL;

echo "All English articles have been copied to non-English articles" . PHP_EOL;



// close connection to WP database
$conn->close();
