<?php
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);
$cat->id = isset($_GET['id']) ? $_GET['id'] : null;

if ($cat->id === null) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

if ($cat->read_single()) {
    echo json_encode([
        "id" => $cat->id,
        "category" => $cat->category
    ]);
} else {
    echo json_encode(["message" => "category_id Not Found"]);
}
?>
