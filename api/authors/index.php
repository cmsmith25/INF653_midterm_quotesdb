<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

    //Will handle CORS
    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }



    switch ($method) {
        case 'GET':
            //Is the request for all or a single record?
            if (isset($_GET['id'])) {
                // Include the read or read_single file based on the request
                require_once 'read_single.php';
            } else {
                require_once 'read.php';
            }
                break;
        case 'POST':
            // Include the create file
                require_once 'create.php';
                break;
        case 'PUT':
            // Include the update file
                require_once 'update.php';
                break;
        case 'DELETE':
            // Include the delete file
                require_once 'delete.php';
                break;
        default:
            echo json_encode(["message" => "Request method not allowed."]);
                break;
    }
    
    