<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$quo = new Quote($db);
$aut = new Author($db);
$cat = new Category($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Set data
$quo->quote = $data->quote;
$quo->author_id = $data->author_id;
$quo->category_id = $data->category_id;

$aut->id = $data->author_id;
$cat->id = $data->category_id;

// Check that author exists
$aut->read_single();
if (!$aut->author) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

// Check that category exists
$cat->read_single();
if (!$cat->category) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

// Create the quote
if ($quo->create()) {
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
