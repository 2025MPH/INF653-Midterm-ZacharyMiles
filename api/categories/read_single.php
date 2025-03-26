<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
$category->id = isset($_GET['id']) ? $_GET['id'] : null;

if ($category->id == null) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$category->read_single();  // Should set $category->category

if ($category->category != null) {
    $category_item = array(
        "id" => $category->id,
        "category" => $category->category
    );
    echo json_encode($category_item);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
?>
