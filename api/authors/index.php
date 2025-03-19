<?php


header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];


    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    switch ($method) {
        case 'GET':
            // Include the read or read_single file based on the request
            include_once 'authors/read.php';
            break;
        case 'POST':
            // Include the create file
            include_once 'authors/create.php';
            break;
        case 'PUT':
            // Include the update file
            include_once 'authors/update.php';
            break;
        case 'DELETE':
            // Include the delete file
            include_once 'authors/delete.php';
            break;
        default:
            echo json_encode(["message" => "Request method not allowed."]);
            break;
    }
    