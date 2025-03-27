<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    //Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();

    //Instantiate quote object
    $quotes = new Quote($db);

    //Assign filter parameters if set
    if (isset($_GET['author_id'])){
        $quotes->author_id = $_GET['author_id'];
    }
    if (isset($_GET['category_id'])){
        $quotes->category_id = $_GET['category_id'];
    }

    //Execute the query
    $result = $quotes->read();
    $num = $result->rowCount();

    //Initialize array to hold quotes
    $quotes_arr = array();

    if($num > 0){
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $quote_item = array(
                'id'       => $id,
                'author'   => $author,
                'quote'    => html_entity_decode($quote),
                'category' => $category
            );
            array_push($quotes_arr, $quote_item);
        }
        echo json_encode($quotes_arr);
    } else {
        // Return an empty array if no quotes are found
        echo json_encode([]);
    }
?>
