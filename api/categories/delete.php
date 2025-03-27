<?php
// delete.php (Categories) Deletes a category record from the database. Returns a JSON object with the deleted category's id upon success, or an error message if deletion fails.

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$cat = new Category($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
} else {
    $cat->id = $data->id;
    if ($cat->delete()){
        echo json_encode(["id" => $cat->id]);
    } else {
        echo json_encode(["message" => "No Categories Found"]);
    }
}
?>
