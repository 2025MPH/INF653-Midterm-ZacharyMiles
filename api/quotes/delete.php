<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quo = new Quote($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    http_response_code(400);
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quo->id = $data->id;

if ($quo->delete()) {
    http_response_code(200);
    echo json_encode(["id" => $quo->id]);
} else {
    http_response_code(404);
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
