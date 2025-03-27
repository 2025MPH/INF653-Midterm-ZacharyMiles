<?php
// update.php - Updates an existing quote record after validating input and foreign keys.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

// Instantiate database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote model
$quo = new Quote($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate required parameters
if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Set properties for the quote
$quo->id = $data->id;
$quo->quote = $data->quote;
$quo->author_id = $data->author_id;
$quo->category_id = $data->category_id;

// Instantiate Author and Category models to validate foreign keys
$aut = new Author($db);
$cat = new Category($db);
$aut->id = $quo->author_id;
$cat->id = $quo->category_id;

// Validate that the category exists
$cat->read_single();
if (!$cat->category) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

// Validate that the author exists
$aut->read_single();
if (!$aut->author) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

// Update the quote record
if ($quo->update()) {
    echo json_encode([
        "id"          => $quo->id,
        "quote"       => $quo->quote,
        "author_id"   => $quo->author_id,
        "category_id" => $quo->category_id
    ]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
