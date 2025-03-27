<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization.X-Requested-With');
 
    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
 
    // Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();
 
    $quo = new Quote($db);
 
    // Get the raw posted data
    $data = json_decode(file_get_contents("php://input"));
 
    if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
        echo json_encode(["message" => "Missing Required Parameters"]);
        exit();
    }
 
    $quo->id = $data->id;
    $quo->quote = $data->quote;
    $quo->author_id = $data->author_id;
    $quo->category_id = $data->category_id;
 
    // Validate foreign keys
    $aut = new Author($db);
    $cat = new Category($db);
    $aut->id = $data->author_id;
    $cat->id = $data->category_id;
 
    $aut->read_single();
    if (!$aut->author) {
        echo json_encode(["message" => "author_id Not Found"]);
        exit();
    }
 
    $cat->read_single();
    if (!$cat->category) {
        echo json_encode(["message" => "category_id Not Found"]);
        exit();
    }
 
    // Update quote
    if ($quo->update()) {
        echo json_encode([
            "id"          => $quo->id,
            "quote"       => $quo->quote,
            "author_id"   => $quo->author_id,
            "category_id" => $quo->category_id
        ]);
    } else {
        echo json_encode(["message" => "No Quotes Found"]);
    }
?>
