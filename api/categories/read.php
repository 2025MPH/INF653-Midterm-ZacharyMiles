<?php
//read.php (Categories) Retrieves all category records from the database and returns them as a JSON array. If no records are found, returns an empty array.


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);
$result = $cat->read();
$num = $result->rowCount();

$categories_arr = array();

if ($num > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $category_item = array(
            'id' => $id,
            'category' => $category
        );
        array_push($categories_arr, $category_item);
    }
    echo json_encode($categories_arr);
} else {
    // Return an empty array if no categories are found
    echo json_encode([]);
}
?>
