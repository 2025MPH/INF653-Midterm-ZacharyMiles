<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->author) || empty($data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author->id = $data->id;
$author->author = $data->author;

if ($author->update()) {
    $author_item = array(
        "id" => $author->id,
        "author" => $author->author
    );
    echo json_encode($author_item);
} else {
    echo json_encode(["message" => "No Authors Found"]);
}
?>
