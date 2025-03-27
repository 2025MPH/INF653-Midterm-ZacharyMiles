<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
 
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';
 
    $database = new Database();
    $db = $database->connect();
 
    $aut = new Author($db);
    $result = $aut->read();
    $num = $result->rowCount();
 
    if ($num > 0) {
        $author_arr = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $author_item = array(
                'id' => $id,
                'author' => $author
            );
            $author_arr[] = $author_item;
        }
        echo json_encode($author_arr);
    } else {
        // Return an empty array if no authors found
        echo json_encode([]);
    }
?>
