<?php
// delete.php - Deletes a quote record and returns a JSON object with the deleted id.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate database and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote model
$quo = new Quote($db);

// Get the raw posted data
$data = json_decode(file_get_contents("php://input"));

// Validate that the id parameter is provided
if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Set the id for deletion
$quo->id = $data->id;

// Delete the quote and return the response
if ($quo->delete()) {
    echo json_encode(["id" => $quo->id]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
