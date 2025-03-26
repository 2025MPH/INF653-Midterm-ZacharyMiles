<?php

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $category->id = isset($data->id) ? $data->id : null;
    $category->category = isset($data->category) ? $data->category : null;


    //Update category
    if(isset($category->category) && isset($category->id)){
        if($category->update()){
            //Create array
            $category_arr = array(
                'id'            => $category->id,
                'category'        => $category->category,
            );

            // Make JSON
            print_r(json_encode($category_arr));
        }else{
            echo json_encode(
                array('message' => 'Category Not Updated')
            );  
        }
    }else{
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );  
    }