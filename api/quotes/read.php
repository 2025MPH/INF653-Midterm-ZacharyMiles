<?php

// Set CORS and content-type headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include necessary files for database connection and Quote model
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Create a new Database instance and establish a connection
$database = new Database();
$db = $database->connect();

// Instantiate the Quote model
$quotes = new Quote($db);

// If filtering parameters are provided in the URL, assign them to the model
if (isset($_GET['author_id'])) {
    $quotes->author_id = $_GET['author_id'];
}
if (isset($_GET['category_id'])) {
    $quotes->category_id = $_GET['category_id'];
}

// Execute the query using the read() method from the model
$result = $quotes->read();
$num = $result->rowCount();

// Initialize an array to store quote objects
$quotes_arr = array();

// If records exist, build the array
if ($num > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Extract the row fields into variables
        extract($row);
        // Create an associative array for each quote
        $quote_item = array(
            'id'       => $id,
            'quote'    => html_entity_decode($quote),
            'author'   => $author,
            'category' => $category
        );
        array_push($quotes_arr, $quote_item);
    }
    // Return the array as JSON
    echo json_encode($quotes_arr);
} else {
    // Return an empty array if no quotes are found
    echo json_encode([]);
}
?>
