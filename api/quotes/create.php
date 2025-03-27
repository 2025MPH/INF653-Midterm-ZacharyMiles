<?php

// Set headers for CORS, content type, and allowed methods
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files for database connection and models
include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

// Instantiate the database and establish connection
$database = new Database();
$db = $database->connect();

// Instantiate Quote, Author, and Category models
$quo = new Quote($db);
$aut = new Author($db);
$cat = new Category($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate that required fields are provided
if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Set properties on the models from input data
$quo->quote = $data->quote;
$quo->author_id = $data->author_id;
$quo->category_id = $data->category_id;
$aut->id = $data->author_id;
$cat->id = $data->category_id;

// Validate that the provided author exists
$aut->read_single();
if (!$aut->author) {
    echo json_encode(["message" => "author_id Not Found"]);
    exit();
}

// Validate that the provided category exists
$cat->read_single();
if (!$cat->category) {
    echo json_encode(["message" => "category_id Not Found"]);
    exit();
}

// Create the new quote record
if ($quo->create()){
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
