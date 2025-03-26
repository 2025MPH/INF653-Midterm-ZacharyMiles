<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
} else {
    $cat->category = $data->category;
    if ($cat->create()){
        echo json_encode(["id" => $db->lastInsertId(), "category" => $cat->category]);
    } else {
        echo json_encode(["message" => "Category Not Created"]);
    }
}
?>
