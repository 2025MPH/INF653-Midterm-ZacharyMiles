<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category->id = $data->id;

if ($category->delete()) {
    echo json_encode(["id" => $category->id]);
} else {
    echo json_encode(["message" => "No Categories Found"]);
}
?>
