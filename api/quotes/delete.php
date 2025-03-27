<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');
 
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
 
    // Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();
 
    $quo = new Quote($db);
    $data = json_decode(file_get_contents("php://input"));
 
    if (!isset($data->id)) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit();
    }
 
    $quo->id = $data->id;
 
    if ($quo->delete()) {
        echo json_encode(["id" => $quo->id]);
    } else {
        echo json_encode(["message" => "No Quotes Found"]);
    }
?>
