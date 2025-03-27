<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// Handle OPTIONS requests for CORS
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

if ($method === 'GET') {
    try {
        if (isset($_GET['id'])) {
            require_once 'read_single.php';
        } else {
            require_once 'read.php';
        }
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else if ($method === 'POST') {
    try {
        require_once 'create.php';
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else if ($method === 'PUT') {
    try {
        require_once 'update.php';
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else if ($method === 'DELETE') {
    try {
        require_once 'delete.php';
    } catch (ErrorException $e) {
        echo json_encode(["message" => "Required file not found!"]);
    }
} else {
    echo json_encode(["message" => "No function requested"]);
}
?>
