<?php
header("Content-Type: application/json");

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();

$aut = new Author($db);
$result = $aut->read();  // Returns all authors
$num = $result->rowCount();

$authors_arr = array();

if ($num > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $author_item = array(
            "id" => $id,
            "author" => $author
        );
        $authors_arr[] = $author_item;
    }
    echo json_encode($authors_arr);
} else {
    // Return empty array if no authors found
    echo json_encode([]);
}
?>
