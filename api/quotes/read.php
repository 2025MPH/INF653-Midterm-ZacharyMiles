<?php
    // Headers
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $quote = new Quote($db);

    // Quotes quote query
    $result = $quote->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if($num > 0){
        // Quotes array
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_item = array(
                'id'            => $id,
                'quote'         => $quote,
                'author'        => $author,
                'category'      => $category
            );

            //Push to "data"
            array_push($quotes_arr, $quote_item);
        }

        // Turn to JSON and output
        echo json_encode($quotes_arr);
    }else{
        // No Categories
        echo json_encode(
            array(
                'message' => 'No Quotes Found'
            )
        );
    }