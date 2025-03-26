<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// Get posted data (expects JSON)
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

if ($quote->create()) {
    $quote_item = array(
        "id"          => $quote->id,
        "quote"       => $quote->quote,
        "author_id"   => $quote->author_id,
        "category_id" => $quote->category_id
    );
    echo json_encode($quote_item);
} else {
    // Return the correct error message (adjust as per your model's validation)
    echo json_encode(["message" => "author_id Not Found"]);
}
?>
