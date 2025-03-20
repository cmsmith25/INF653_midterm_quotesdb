
<?php


header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];


    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    //Will get the HTTP method
    $method = $_SERVER['REQUEST_METHOD'];


    switch ($method) {
        case 'GET':
            //Is the request for all or a single record?
            if (isset($_GET['id'])) {
                // Include the read or read_single file based on the request
                include_once 'categories/read_single.php';
            } else {
                include_once 'categories/read.php';
            }
            break;
        case 'POST':
            // Include the create file
            include_once 'categories/create.php';
            break;
        case 'PUT':
            // Include the update file
            include_once 'categories/update.php';
            break;
        case 'DELETE':
            // Include the delete file
            include_once 'categories/delete.php';
            break;
        default:
            echo json_encode(["message" => "Request method not allowed."]);
            break;
    }
    