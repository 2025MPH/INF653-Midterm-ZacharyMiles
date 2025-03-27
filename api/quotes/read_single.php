<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
 
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
 
    // Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();
 
    // Instantiate quote object
    $quo = new Quote($db);
    $quo->id = isset($_GET['id']) ? $_GET['id'] : null;
 
    if ($quo->id === null) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit();
    }
 
    // Use read_single() to get the quote data (uses LEFT JOIN with COALESCE)
    if ($quo->read_single()){
        $quote_item = array(
            "id"       => $quo->id,
            "quote"    => $quo->quote,
            "author"   => $quo->author,
            "category" => $quo->category
        );
        echo json_encode($quote_item);
    } else {
        echo json_encode(["message" => "No Quotes Found"]);
    }
?>
