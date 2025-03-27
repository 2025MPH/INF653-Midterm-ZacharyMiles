<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quo = new Quote($db);
$quo->id = isset($_GET['id']) ? $_GET['id'] : null;
if ($quo->id == null) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

if ($quo->read_single()){
    echo json_encode([
        "id"       => $quo->id,
        "quote"    => $quo->quote,
        "author"   => $quo->author,
        "category" => $quo->category
    ]);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}
?>
