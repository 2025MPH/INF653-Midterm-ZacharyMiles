<?php
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $quote->id = isset($data->id) ? $data->id : null;

    //Delete quote
    if(isset($quote->id)){
        if($quote->delete()){
            //Create array
            $quote_arr = array(
                'id'            => $quote->id,
            );

            // Make JSON
            print_r(json_encode($quote_arr));
        }else{
            echo json_encode(
                array('message' => 'No Quotes Found')
            );  
        }
    }else{
        echo json_encode(
            array('message' => 'No Quotes Found')
        ); 
    }