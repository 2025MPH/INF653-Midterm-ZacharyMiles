<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$aut = new Author($db);
$aut->id = isset($_GET['id']) ? $_GET['id'] : null;
if ($aut->id === null) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

if ($aut->read_single()){
    echo json_encode([
        "id" => $aut->id,
        "author" => $aut->author
    ]);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
?>
