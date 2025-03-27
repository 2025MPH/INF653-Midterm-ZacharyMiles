<?php

// Set headers for CORS, content type, and allowed methods
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

// Include necessary files for database connection and the Quote model
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate the database and connect
$database = new Database();
$db = $database->connect();

// Instantiate the Quote model
$quo = new Quote($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate that the id parameter is provided
if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Set the id on the Quote model
$quo->id = $data->id;

// Attempt to delete the quote record and return the appropriate response
if ($quo->delete()){
    echo json_encode(["id" => $quo->id]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
