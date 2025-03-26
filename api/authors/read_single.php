<?php
    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate authors object
    $author = new Author($db);

    // GET ID
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    //Get post
    $author->read_single();

    //Create array
    if((isset($author->id) && isset($author->author))){
        $author_arr = array(
            'id'            => $author->id,
            'author'        => $author->author,
        );
    
        // Make JSON
        print_r(json_encode($author_arr));
      }else{
        print_r(json_encode(array("message" => "author_id Not Found")));
      }