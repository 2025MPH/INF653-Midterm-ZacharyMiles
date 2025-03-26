<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$aut = new Author($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
} else {
    $aut->id = $data->id;
    if ($aut->delete()){
        echo json_encode(["id" => $aut->id]);
    } else {
        echo json_encode(["message" => "No Authors Found"]);
    }
}
?>
