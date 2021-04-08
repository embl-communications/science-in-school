<?php
// Script for postprocessing attached files and images for issues and articles

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



// Second step: Get all images and files in fields "iss_cover_image" and "iss_pdf"
$metaIdToMetaValueArray = array();

$sql = "SELECT `meta_id`, `meta_value`  FROM `wp_postmeta` 
            WHERE `meta_key` 
                IN ('iss_cover_image', 'iss_pdf', 'art_slider_image', 'art_teaser_image', 'art_pdf');";
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

    $metaId = $row['meta_id'];
    $metaValue = $row['meta_value'];

    $metaIdToMetaValueArray[$metaId] = $guidToPostIdMappingArray[$metaValue];
}
$statement->close();



// Update database table

// Prepared Statements for updating data
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `meta_id`=?;";
$stmt = $conn->prepare($sql);
$metaValue = '';
$metaId = 0;
$stmt->bind_param("si", $metaValue, $metaId);

foreach ($metaIdToMetaValueArray as $currentMetaId => $currentMetaValue) {
    if(empty($currentMetaId) || empty($currentMetaValue)){
        echo "ERROR: Empty currentMetaId or currentMetaValue " . PHP_EOL;
        continue;
    }
    $metaValue = $currentMetaValue;
    $metaId = $currentMetaId;

    $stmt->execute();
}



echo "All images and files have been migrated for issues and articles" . PHP_EOL;


// close connection to WP database
$conn->close();
