<?php
// Script for copying terms assigned to English articles to their translated articles


include "../postprocess/include-postprocess.php";

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

// 1.: Get post ids of English articles AND mapping trid -> english postId
$postIdsEnglishArticlesArray = array();
$mappingTridToEnglishPostIdArray = array();

$sql = "SELECT `element_id`, `trid` FROM `wp_icl_translations` WHERE `language_code` = 'en' AND `element_type` = 'post_sis-article';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['element_id'])) {
        echo "Error: element_id " . PHP_EOL;
        continue;
    }
    if (empty($row['trid'])) {
        echo "Error: trid " . PHP_EOL;
        continue;
    }
    $postIdsEnglishArticlesArray[] = $row['element_id'];
    $mappingTridToEnglishPostIdArray[$row['element_id']] = $row['trid'];
}
$statement->close();

echo "Array postIdsEnglishArticlesArray has " . count($postIdsEnglishArticlesArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($postIdsEnglishArticlesArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($postIdsEnglishArticlesArray)) . PHP_EOL;
echo PHP_EOL;

echo "Array mappingTridToEnglishPostIdArray has " . count($mappingTridToEnglishPostIdArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($mappingTridToEnglishPostIdArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($mappingTridToEnglishPostIdArray)) . PHP_EOL;
echo PHP_EOL;


// 2.: Get post ids of Non-English articles
$postIdsNonEnglishArticlesArray = array();
$mappingTridToNonEnglishPostIdsArray = array();
$languageCodeArray = array();


$sql = "SELECT `element_id`, `trid`, `language_code` FROM `wp_icl_translations` WHERE `language_code` != 'en' AND `element_type` = 'post_sis-article';";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['element_id'])) {
        echo "Error: element_id " . PHP_EOL;
        continue;
    }
    if (empty($row['trid'])) {
        echo "Error: trid " . PHP_EOL;
        continue;
    }
    if (empty($row['language_code'])) {
        echo "Error: language_code " . PHP_EOL;
        continue;
    }

    $postIdsNonEnglishArticlesArray[] = $row['element_id'];
    if(!array_key_exists($row['trid'], $mappingTridToNonEnglishPostIdsArray)){
        $mappingTridToNonEnglishPostIdsArray[$row['trid']] = array();
    }
    $mappingTridToNonEnglishPostIdsArray[$row['trid']][] = $row['element_id'];
    $languageCodeArray[$row['element_id']] = $row['language_code'];
}
$statement->close();

echo "Array postIdsNonEnglishArticlesArray has " . count($postIdsNonEnglishArticlesArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($postIdsNonEnglishArticlesArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($postIdsNonEnglishArticlesArray)) . PHP_EOL;
echo PHP_EOL;

echo "Array mappingTridToNonEnglishPostIdsArray has " . count($mappingTridToNonEnglishPostIdsArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($mappingTridToNonEnglishPostIdsArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($mappingTridToNonEnglishPostIdsArray)) . PHP_EOL;
echo PHP_EOL;

echo "Array languageCodeArray has " . count($languageCodeArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($languageCodeArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($languageCodeArray)) . PHP_EOL;
echo PHP_EOL;


// 3.: Get slugs/post_name entries of English articles
$slugEntriesEnglishArticlesArray = array();
$doubleSlugsArray = array();

$sql = "SELECT `ID`, `post_name` FROM `wp_posts` WHERE `post_type` = 'sis-article' AND `ID` IN (SELECT `element_id` FROM `wp_icl_translations` WHERE `language_code` = 'en')";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['ID'])) {
        echo "Error: ID " . PHP_EOL;
        continue;
    }
    if (empty($row['post_name'])) {
        echo "Error: post_name " . PHP_EOL;
        continue;
    }

    if(array_key_exists($row['post_name'], $doubleSlugsArray)){
        echo "ERROR DOUBLE SLUG: " . $row['post_name'] . ' CHANGE FOR POST-ID:' .  $row['ID'] . ' ALREADY HERE POST-ID:' . $doubleSlugsArray[$row['post_name']] . PHP_EOL;
    }
    $doubleSlugsArray[$row['post_name']] = $row['ID'];

    $slugEntriesEnglishArticlesArray[$row['ID']] = $row['post_name'];
}
$statement->close();

echo "Array slugEntriesEnglishArticlesArray has " . count($slugEntriesEnglishArticlesArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($slugEntriesEnglishArticlesArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($slugEntriesEnglishArticlesArray)) . PHP_EOL;
echo PHP_EOL;


// 4.: Add slugs for non-English articles
//$sql = "REPLACE INTO `wp_posts` (`post_id`, `post_name`)  VALUES (?, ?);";
//$stmt = $conn->prepare($sql);
$postId = 0;
$postName = '';
//$stmt->bind_param("is", $postId, $postName);

$numberPostmetaInserts = 0;
foreach ($slugEntriesEnglishArticlesArray as $currentPostId => $currentSlug) {
    if(empty($currentPostId)){
        echo "ERROR: Empty currentPostId " . $currentPostId . PHP_EOL;
        continue;
    }

    if(empty($currentSlug)){
        echo "ERROR: Empty currentSlug " . $currentSlug . PHP_EOL;
        continue;
    }

    $trid = $mappingTridToEnglishPostIdArray[$currentPostId];
    if(empty($trid)){
        continue;
    }
    // get non-english article ids for trid
    if(!array_key_exists($trid, $mappingTridToNonEnglishPostIdsArray)){
        // only english
        continue;
    }
    $nonEnglishArray = $mappingTridToNonEnglishPostIdsArray[$trid];
    if(!is_array($nonEnglishArray)){
        continue;
    }


    foreach($nonEnglishArray as $currentNonEnglishPostId){
        $currentLanguageCode = $languageCodeArray[$currentNonEnglishPostId];
        if(empty($currentNonEnglishPostId)){
            echo "Error language code: " . $currentNonEnglishPostId;
            continue;
        }

        $postId = $currentNonEnglishPostId;
        $postName = $currentSlug . '-' . $currentLanguageCode;

        echo "UPDATE `wp_posts` SET `post_name` = '" . $postName . "' WHERE `ID` = " . $postId  . ";" . PHP_EOL;

        //$stmt->execute();
        $numberPostmetaInserts++;
    }
}
//$stmt->close();

echo "Number of slug entries added: " . $numberPostmetaInserts;




// close connection to WP database
$conn->close();
