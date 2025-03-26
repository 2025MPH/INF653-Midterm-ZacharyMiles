<?php

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $author->id = isset($data->id) ? $data->id : null ;
    $author->author = isset($data->author) ? $data->author : null;


    if(isset($author->author) && isset($author->id)){
        //Update author
        if($author->update()){
            //Create array
            $author_arr = array(
                'id'            => $author->id,
                'author'        => $author->author,
            );

            // Make JSON
            print_r(json_encode($author_arr));
        }else{
            echo json_encode(
                array('message' => 'Author Not Updated')
            );  
        }
    }else{
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );  
    }