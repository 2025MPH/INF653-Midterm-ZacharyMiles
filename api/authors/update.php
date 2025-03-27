<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');
 
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
 
    $database = new Database();
    $db = $database->connect();
 
    $aut = new Author($db);
    $data = json_decode(file_get_contents("php://input"));
 
    if (!isset($data->id) || !isset($data->author)) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit();
    }
 
    $aut->id = $data->id;
    $aut->author = $data->author;
 
    if ($aut->update()){
        echo json_encode(["id" => $aut->id, "author" => $aut->author]);
    } else {
        echo json_encode(["message" => "author_id Not Found"]);
    }
?>
