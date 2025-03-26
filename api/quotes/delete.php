<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$quote->id = $data->id;

if ($quote->delete()) {
    echo json_encode(["id" => $quote->id]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
