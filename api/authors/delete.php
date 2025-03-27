<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');
 
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
 
    //Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();
 
    //Instantiate blog author object
    $aut = new Author($db);
    $data = json_decode(file_get_contents("php://input"));
 
    //data is not set
    if(!isset($data->id)){
        echo json_encode(array('message' => 'Missing Required Parameters'));
        exit();
    } else {
        $aut->id = $data->id;
        if($aut->delete()){
            echo json_encode(array('id' => $aut->id));
        } else {
            echo json_encode(array('message' => 'No Authors Found'));
        }
    }
?>
