<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();

    //Instantiate category object
    $cat = new Category($db);

    //Category query
    $result = $cat->read();
    $num = $result->rowCount();

    //Check if any categories found
    if($num > 0){
        $category_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $category_item = array(
                'id' => $id,
                'category' => $category
            );
            array_push($category_arr, $category_item);
        }
        // Return array of categories
        echo json_encode($category_arr);
    } else {
        // Return an empty array if no categories found
        echo json_encode([]);
    }
?>
