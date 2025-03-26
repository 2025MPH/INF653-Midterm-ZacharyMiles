<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category) || empty($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category->category = $data->category;

if ($category->create()) {
    $category_item = array(
        "id" => $category->id,
        "category" => $category->category
    );
    echo json_encode($category_item);
} else {
    echo json_encode(["message" => "Category Not Created"]);
}
?>
