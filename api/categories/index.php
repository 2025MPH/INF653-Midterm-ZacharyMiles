<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);
$result = $cat->read();  // Returns all categories
$num = $result->rowCount();

$categories_arr = array();

if ($num > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $category_item = array(
            "id" => $id,
            "category" => $category
        );
        $categories_arr[] = $category_item;
    }
    echo json_encode($categories_arr);
} else {
    echo json_encode([]);
}
?>
