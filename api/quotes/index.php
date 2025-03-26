<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);
$result = $quote->readAll(); // This method should join authors and categories to return: id, quote, author, category
$num = $result->rowCount();

$quotes_arr = array();

if ($num > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Each row must have: id, quote, author, category
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
    // Return an empty array when no quotes exist
    echo json_encode([]);
}
?>
