<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');
 
    include_once '../../config/Database.php';
    include_once '../../models/Category.php';
 
    $database = new Database();
    $db = $database->connect();
 
    $cat = new Category($db);
    $data = json_decode(file_get_contents("php://input"));
 
    if (!isset($data->id) || !isset($data->category)) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit();
    }
 
    $cat->id = $data->id;
    $cat->category = $data->category;
 
    if ($cat->update()){
        echo json_encode(["id" => $cat->id, "category" => $cat->category]);
    } else {
        echo json_encode(["message" => "category_id Not Found"]);
    }
?>
