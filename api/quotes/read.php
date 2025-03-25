<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Retrieve filter parameters if set
$author_id   = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

$result = $quote->readFiltered($author_id, $category_id);  // This method should apply the filters and join to get author and category names
$num = $result->rowCount();

$quotes_arr = array();

if($num > 0){
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $quote_item = array(
            "id"       => $id,
            "quote"    => $quote,
            "author"   => $author,
            "category" => $category
        );
        $quotes_arr[] = $quote_item;
    }
    echo json_encode($quotes_arr);
} else {
    // Return an empty array when no matching quotes are found
    echo json_encode([]);
}
?>
