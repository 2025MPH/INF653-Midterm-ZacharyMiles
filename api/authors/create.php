<?php
// create.php - Creates a new author record

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$aut = new Author($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
} else {
    $aut->author = $data->author;
    if ($aut->create()){
        echo json_encode(["id" => $db->lastInsertId(), "author" => $aut->author]);
    } else {
        echo json_encode(["message" => "Author Not Created"]);
    }
}
?>
