<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);
$author->id = isset($_GET['id']) ? $_GET['id'] : null;

if ($author->id == null) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    exit();
}

$author->read_single();  // Should set $author->author

if ($author->author != null) {
    $author_item = array(
        "id" => $author->id,
        "author" => $author->author
    );
    echo json_encode($author_item);
} else {
    echo json_encode(["message" => "author_id Not Found"]);
}
?>
