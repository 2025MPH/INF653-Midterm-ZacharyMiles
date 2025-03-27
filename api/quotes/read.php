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
    $quotes = new Quote($db);
 
    // Apply filters if provided
    if (isset($_GET['author_id'])) {
        $quotes->author_id = $_GET['author_id'];
    }
    if (isset($_GET['category_id'])) {
        $quotes->category_id = $_GET['category_id'];
    }
 
    // Execute query
    $result = $quotes->read();
    $num = $result->rowCount();
 
    $quotes_arr = array();
 
    if ($num > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Each row must have keys: id, quote, author, and category
            extract($row);
            $quote_item = array(
                'id'       => $id,
                'quote'    => html_entity_decode($quote),
                'author'   => $author,
                'category' => $category
            );
            $quotes_arr[] = $quote_item;
        }
        echo json_encode($quotes_arr);
    } else {
        // Always return an array (empty array if no quotes found)
        echo json_encode([]);
    }
?>
