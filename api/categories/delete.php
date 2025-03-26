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
    $category->id = $data->id;

    //Delete category
    if($category->delete()){
        //Create array
        $category_arr = array(
            'id'            => $category->id,
        );

        // Make JSON
        print_r(json_encode($category_arr));
    }else{
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );  
    }