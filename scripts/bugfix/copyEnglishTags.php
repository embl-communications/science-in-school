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
    $mappingTridToEnglishPostIdArray['element_id'] = $row['trid'];
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

$sql = "SELECT `element_id`, `trid` FROM `wp_icl_translations` WHERE `language_code` != 'en' AND `element_type` = 'post_sis-article';";
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
    $postIdsNonEnglishArticlesArray[] = $row['element_id'];
    if(!array_key_exists($row['trid'], $mappingTridToNonEnglishPostIdsArray)){
        $mappingTridToNonEnglishPostIdsArray[$row['trid']] = array();
    }
    $mappingTridToNonEnglishPostIdsArray[$row['trid']][] = $row['element_id'];
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


// 3.: Get wp_postmeta entries of English articles
$postmetaEntriesEnglishArticlesArray = array();

$sql = "SELECT `post_id`, `meta_key`, `meta_value` FROM `wp_postmeta` where `meta_key` 
        IN ('art_ages', 'art_article_type', 'art_editor_tags', 'art_institutions', 'art_issue', 'art_license','art_reviewer_tags', 'art_series', 'art_topics')
        AND `post_id` IN (SELECT `element_id` FROM `wp_icl_translations` WHERE `language_code` = 'en' AND `element_type` = 'post_sis-article');";
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

    if(!array_key_exists($row['post_id'], $postmetaEntriesEnglishArticlesArray)){
        $postmetaEntriesEnglishArticlesArray[$row['post_id']] = array();
    }
    $postmetaEntriesEnglishArticlesArray[$row['post_id']][$row['meta_key']] = $row['meta_value'];
}
$statement->close();

echo "Array postmetaEntriesEnglishArticlesArray has " . count($postmetaEntriesEnglishArticlesArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($postmetaEntriesEnglishArticlesArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($postmetaEntriesEnglishArticlesArray)) . PHP_EOL;
echo PHP_EOL;


// 4.: Get wp_term_relationships entries of English articles
$termRelationshipsEnglishArticlesArray = array();

$sql = "SELECT `object_id`, `term_taxonomy_id`, `term_order` FROM `wp_term_relationships` 
        WHERE `object_id` IN (SELECT `element_id` FROM `wp_icl_translations` WHERE `language_code` = 'en' AND `element_type` = 'post_sis-article');";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

while ($row = $result->fetch_assoc()) {
    if (empty($row['object_id'])) {
        echo "Error: object_id " . PHP_EOL;
        continue;
    }
    if (empty($row['term_taxonomy_id'])) {
        echo "Error: term_taxonomy_id " . PHP_EOL;
        continue;
    }

    if(!array_key_exists($row['object_id'], $termRelationshipsEnglishArticlesArray)){
        $termRelationshipsEnglishArticlesArray[$row['object_id']] = array();
    }
    $termRelationshipsEnglishArticlesArray[$row['object_id']][$row['term_taxonomy_id']] = $row['term_order'];
}
$statement->close();

echo "Array termRelationshipsEnglishArticlesArray has " . count($termRelationshipsEnglishArticlesArray) . " entries" . PHP_EOL;
echo "Min guid id is: " . min(array_keys($termRelationshipsEnglishArticlesArray)) . PHP_EOL;
echo "Max guid id is: " . max(array_keys($termRelationshipsEnglishArticlesArray)) . PHP_EOL;
echo PHP_EOL;


// 5.: Delete tags for Non-English articles in wp_postmeta
$sql = "DELETE FROM `wp_postmeta` WHERE `meta_key` 
    IN ('art_ages', 'art_article_type', 'art_editor_tags', 'art_institutions', 'art_issue', 'art_license','art_reviewer_tags', 'art_series', 'art_topics') 
    AND `post_id` IN (SELECT `element_id` FROM `wp_icl_translations` WHERE `language_code` != 'en' AND `element_type` = 'post_sis-article');";
$statement = $conn->prepare($sql);
$statement->execute();
$statement->close();


// 6.: Delete tags for Non-English articles in wp_term_relationships
$sql = "DELETE FROM `wp_term_relationships`
    WHERE `object_id` IN (SELECT `element_id` FROM `wp_icl_translations` WHERE `language_code` != 'en' AND `element_type` = 'post_sis-article');";
$statement = $conn->prepare($sql);
$statement->execute();
$statement->close();


// 7.: Add entries in wp_postmeta for non-English articles
$sql = "INSERT INTO `wp_postmeta` (`post_id`, `meta_key`, `meta_value`) 
    VALUES (?, ?, ?);";
$stmt = $conn->prepare($sql);
$postId = 0;
$metaKey = '';
$metaValue = '';
$stmt->bind_param("iss", $postId, $metaKey, $metaValue);

foreach ($postmetaEntriesEnglishArticlesArray as $currentPostId => $currentEntriesArray) {
    if(empty($currentPostId)){
        echo "ERROR: Empty currentPostId " . PHP_EOL;
        continue;
    }

    foreach($currentEntriesArray as $currentMetaKey => $currentMetaValue){
        if(empty($currentMetaKey)){
            echo "ERROR: Empty currentMetaKey " . PHP_EOL;
            continue;
        }

        // get trid for english postId
        if(!array_key_exists($currentPostId, $mappingTridToEnglishPostIdArray)){
            // only english
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
            $postId = $currentNonEnglishPostId;
            $metaKey = $currentMetaKey;
            $metaValue = $currentMetaValue;
            $stmt->execute();
        }
    }
}
$stmt->close();


// 8.: Add entries in wp_term_relationships for non-English articles
$sql = "INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`)  
    VALUES (?, ?, ?);";
$stmt = $conn->prepare($sql);
$objectId = 0;
$termTaxonomyId = 0;
$termOrder = 0;
$stmt->bind_param("iii", $objectId, $termTaxonomyId, $termOrder);

foreach ($termRelationshipsEnglishArticlesArray as $currentObjectId => $currentEntriesArray) {
    if(empty($currentObjectId)){
        echo "ERROR: Empty currentObjectId " . PHP_EOL;
        continue;
    }

    foreach($currentEntriesArray as $currentTermTaxonomyId => $currentTermOrder){
        if(empty($currentTermTaxonomyId)){
            echo "ERROR: Empty currentTermTaxonomyId " . PHP_EOL;
            continue;
        }

        // get trid for english postId
        if(!array_key_exists($currentObjectId, $mappingTridToEnglishPostIdArray)){
            // only english
            continue;
        }
        $trid = $mappingTridToEnglishPostIdArray[$currentObjectId];
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
            $objectId = $currentNonEnglishPostId;
            $termTaxonomyId = $currentTermTaxonomyId;
            $termOrder = $currentTermOrder;
            $stmt->execute();
        }
    }
}
$stmt->close();


echo "All English articles have been copied to non-English articles" . PHP_EOL;



// close connection to WP database
$conn->close();
