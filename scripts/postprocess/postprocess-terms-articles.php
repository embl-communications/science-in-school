<?php
// Script for postprocessing terms and their custom fields for articles


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

// First: Terms for articles
$editorTags = array();          // multiple
$reviewerTags = array();        // multiple
$ageTags = array();             // multiple
$institutionTags = array();     // multiple
$issueTags = array();           // one
$articleTypeTags = array();     // one
$topicTags = array();           // multiple
$seriesTags = array();          // multiple
$licenseTags = array();         // one

$sql = "SELECT `term_id`, `object_id`, `taxonomy` 
    FROM `wp_term_relationships` INNER JOIN `wp_term_taxonomy` 
    ON `wp_term_relationships`.`term_taxonomy_id` = `wp_term_taxonomy`.`term_taxonomy_id` 
    WHERE `object_id` IN (SELECT `ID` FROM `wp_posts` WHERE `post_type` = 'sis-article');";
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

    $taxonomy = $row['taxonomy'];
    $postId = $row['object_id'];
    $termId = $row['term_id'];

    // editor tags
    if($taxonomy == 'sis-editor-tags'){
        if(array_key_exists($postId, $editorTags)){
            $editorTags[$postId] = array();
        }
        $tmpArray = $editorTags[$postId];
        if(!is_array($tmpArray)){
            $tmpArray = array();
        }
        $tmpArray[] = $termId;
        $editorTags[$postId] = $tmpArray;
        continue;
    }

    // reviewer tags
    if($taxonomy == 'sis-reviewer-tags'){
        if(array_key_exists($postId, $reviewerTags)){
            $reviewerTags[$postId] = array();
        }
        $tmpArray = $reviewerTags[$postId];
        if(!is_array($tmpArray)){
            $tmpArray = array();
        }
        $tmpArray[] = $termId;
        $reviewerTags[$postId] = $tmpArray;
        continue;
    }

    // age tags
    if($taxonomy == 'sis-ages'){
        if(array_key_exists($postId, $ageTags)){
            $ageTags[$postId] = array();
        }
        $tmpArray = $ageTags[$postId];
        if(!is_array($tmpArray)){
            $tmpArray = array();
        }
        $tmpArray[] = $termId;
        $ageTags[$postId] = $tmpArray;
        continue;
    }

    // institutions tags
    if($taxonomy == 'sis-institutions'){
        if(array_key_exists($postId, $institutionTags)){
            $institutionTags[$postId] = array();
        }
        $tmpArray = $institutionTags[$postId];
        if(!is_array($tmpArray)){
            $tmpArray = array();
        }
        $tmpArray[] = $termId;
        $institutionTags[$postId] = $tmpArray;
        continue;
    }

    // issue tag
    if($taxonomy == 'sis-issues'){
        $issueTags[$postId] = $termId;
        continue;
    }

    // article type
    if($taxonomy == 'sis-article-types'){
        $articleTypeTags[$postId] = $termId;
        continue;
    }

    // topics tags
    if($taxonomy == 'sis-category'){
        if(array_key_exists($postId, $topicTags)){
            $topicTags[$postId] = array();
        }
        $tmpArray = $topicTags[$postId];
        if(!is_array($tmpArray)){
            $tmpArray = array();
        }
        $tmpArray[] = $termId;
        $topicTags[$postId] = $tmpArray;
        continue;
    }

    // series tags
    if($taxonomy == 'sis-series'){
        if(array_key_exists($postId, $seriesTags)){
            $seriesTags[$postId] = array();
        }
        $tmpArray = $seriesTags[$postId];
        if(!is_array($tmpArray)){
            $tmpArray = array();
        }
        $tmpArray[] = $termId;
        $seriesTags[$postId] = $tmpArray;
        continue;
    }

    // license type
    if($taxonomy == 'sis-license'){
        $licenseTags[$postId] = $termId;
        continue;
    }

}
$statement->close();

echo "Array editorTags has " . count($editorTags) . " entries" . PHP_EOL;
echo "Min postId is: " . min(array_keys($editorTags)) . PHP_EOL;
echo "Max postId is: " . max(array_keys($editorTags)) . PHP_EOL;
echo PHP_EOL;


// Second: stringify inner arrays
foreach ($editorTags as $currentPostId => $currentTermArray) {
    $editorTags[$currentPostId] = serialize($currentTermArray);
}
foreach ($reviewerTags as $currentPostId => $currentTermArray) {
    $reviewerTags[$currentPostId] = serialize($currentTermArray);
}
foreach ($ageTags as $currentPostId => $currentTermArray) {
    $ageTags[$currentPostId] = serialize($currentTermArray);
}
foreach ($institutionTags as $currentPostId => $currentTermArray) {
    $institutionTags[$currentPostId] = serialize($currentTermArray);
}
foreach ($topicTags as $currentPostId => $currentTermArray) {
    $topicTags[$currentPostId] = serialize($currentTermArray);
}
foreach ($seriesTags as $currentPostId => $currentTermArray) {
    $seriesTags[$currentPostId] = serialize($currentTermArray);
}

// Update database table

// Prepared Statements for updating data
// editor tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_editor_tags';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($editorTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// reviewer tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_reviewer_tags';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($reviewerTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// ages tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_ages';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($ageTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// institution tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_institutions';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($institutionTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// issue tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_issue';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($issueTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// article type tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_article_type';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($articleTypeTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// topic tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_topics';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($topicTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// series tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_series';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($seriesTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


// Prepared Statements for updating data
// license tags
$sql = "UPDATE `wp_postmeta` SET `meta_value`=? WHERE `post_id`=? AND `meta_key` = 'art_license';";
$stmt = $conn->prepare($sql);
$postId = 0;
$termId = '';
$stmt->bind_param("si", $termId, $postId);
foreach ($licenseTags as $currentPostId => $currentTermValue) {
    if(empty($currentPostId) || empty($currentTermValue)){
        echo "ERROR: Empty currentPostId or currentTermValue " . PHP_EOL;
        continue;
    }
    $postId = $currentPostId;
    $termId = $currentTermValue;
    $stmt->execute();
}
$stmt->close();


echo "All terms has been postprocessed for articles" . PHP_EOL;


// close connection to WP database
$conn->close();
