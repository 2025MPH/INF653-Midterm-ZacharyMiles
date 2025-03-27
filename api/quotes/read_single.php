<?php

// Set headers for CORS and content type
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files for database connection and Quote model
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Create database instance and connect
$database = new Database();
$db = $database->connect();

// Instantiate the Quote model
$quo = new Quote($db);

// Get the id parameter from the query string
$quo->id = isset($_GET['id']) ? $_GET['id'] : null;
if ($quo->id === null) {
    // If id is not provided, return an error message in JSON format
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

// Retrieve the single quote record
if ($quo->read_single()){
    // Build the JSON object with the required fields
    $quote_item = array(
        "id"       => $quo->id,
        "quote"    => $quo->quote,
        "author"   => $quo->author,
        "category" => $quo->category
    );
    echo json_encode($quote_item);
} else {
    // Return an error message if no quote is found
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
