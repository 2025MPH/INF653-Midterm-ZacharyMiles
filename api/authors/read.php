<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB and CONNECT
    $database = new Database();
    $db = $database->connect();

    //Instantiate author object
    $aut = new Author($db);

    //Author query
    $result = $aut->read();
    $num = $result->rowCount();

    //Check if any authors found
    if($num > 0){
        $author_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $author_item = array(
                'id' => $id,
                'author' => $author
            );
            array_push($author_arr, $author_item);
        }
        // Return array of authors
        echo json_encode($author_arr);
    } else {
        // Return an empty array if no authors found
        echo json_encode([]);
    }
?>
