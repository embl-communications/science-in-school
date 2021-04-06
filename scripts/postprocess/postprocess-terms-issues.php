<?php
// Script for postprocessing terms and their custom fields for issues


// Fix params
$serverName = "vfwpsis_mariadb";
$dbName = "docker";

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

// First: Issue terms for sis-issues
$issueTermIds = array();

$sql = "SELECT `term_id`, `object_id`, `taxonomy` 
    FROM `wp_term_relationships` INNER JOIN `wp_term_taxonomy` 
    ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id` 
    WHERE `object_id` IN (SELECT `ID` FROM `wp_posts` WHERE `post_type` = 'sis-issue');";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['term_id'])) {
        echo "Error: Empty term_id " . PHP_EOL;
        continue;
    }
    if (empty($row['object_id'])) {
        echo "Error: Empty object_id " . PHP_EOL;
        continue;
    }
    if (empty($row['taxonomy'])) {
        echo "Error: Empty taxonomy " . PHP_EOL;
        continue;
    }
    if($row['taxonomy'] == 'sis-issues'){
        $issueTermIds[$row['object_id']] = $row['term_id'];
    }
}
$statement->close();

echo "Array issueTermIds has " . count($issueTermIds) . " entries" . PHP_EOL;
echo "Min object_id is: " . min(array_keys($issueTermIds)) . PHP_EOL;
echo "Max object_id is: " . max(array_keys($issueTermIds)) . PHP_EOL;
echo PHP_EOL;


// Update database table

// Prepared Statements for updating data
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `meta_id`=?;";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);

foreach ($issueTermIds as $currentPostId => $currenttTermId) {
    if(empty($currentPostId) || empty($currenttTermId)){
        echo "ERROR: Empty currentPostId or currenttTermId " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currenttTermId;
    $stmt->execute();
}


echo "All terms has been postprocessed for issues" . PHP_EOL;



// close connection to WP database
$conn->close();
