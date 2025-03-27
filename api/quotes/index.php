<?php
/**
 * index.php
 * 
 * This file acts as the central router for the Quotes API. It inspects the HTTP method
 * of the request and routes the request to the appropriate file (read, read_single, create, update, or delete).
 * 
 * All responses are returned as JSON.
 */

// Set CORS and content type headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Get the current HTTP request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle pre-flight OPTIONS request for CORS
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// Route the request based on HTTP method
if ($method === 'GET') {
    try {
        // If the 'id' parameter is provided in the URL, use the single record file; otherwise, list all quotes
        if (isset($_GET['id'])) {
            require_once 'read_single.php';
        } else {
            require_once 'read.php';
        }
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else if ($method === 'POST') {
    try {
        require_once 'create.php';
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else if ($method === 'PUT') {
    try {
        require_once 'update.php';
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else if ($method === 'DELETE') {
    try {
        require_once 'delete.php';
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else {
    // Fallback response if the method is not supported
    echo json_encode(["message" => "No function requested"]);
}
?>
