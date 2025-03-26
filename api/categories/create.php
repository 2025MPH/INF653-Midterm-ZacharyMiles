<?php
    // Headers
    
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $category->category = isset($data->category) ? $data->category : null;


    if(isset($category->category)){
        $category_id = $category->create();

        //Create category
        if($category_id){
            //Create array
            $category_arr = array(
                'id'              => $category_id,
                'category'        => $category->category,
            );

            // Make JSON
            print_r(json_encode($category_arr));
        }
    }else{
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        ); 
    }