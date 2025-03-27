<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
 
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
 
    $database = new Database();
    $db = $database->connect();
 
    $cat = new Category($db);
    $result = $cat->read();
    $num = $result->rowCount();
 
    if ($num > 0) {
        $category_arr = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $category_item = array(
                'id' => $id,
                'category' => $category
            );
            $category_arr[] = $category_item;
        }
        echo json_encode($category_arr);
    } else {
        // Return an empty array if no categories found
        echo json_encode([]);
    }
?>
