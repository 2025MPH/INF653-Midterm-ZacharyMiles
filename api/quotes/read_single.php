<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Get id from query string
$quote->id = isset($_GET['id']) ? $_GET['id'] : null;

if($quote->id == null){
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->read_single(); // Should set properties: id, quote, author, category

if($quote->quote != null){
    $quote_item = array(
        "id"       => $quote->id,
        "quote"    => $quote->quote,
        "author"   => $quote->author,
        "category" => $quote->category
    );
    echo json_encode($quote_item);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
