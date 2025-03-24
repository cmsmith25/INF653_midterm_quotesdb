<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Initializes my database connection
$database = new Database();
$db = $database->connect();

// Initializes the Author model
$author = new Author($db);

// Get raw POST data
$data =json_decode(file_get_contents("php://input"));

if (!isset($data->author)) {
    echo json_encode(array("message" => "Missing Required Parameters"));
    exit();
}

$author->author = $data->author;

//Create author
if($author->create()) {
    echo json_encode(array("id" => $author->id, "author" => $author->author));
} else {
    echo json_encode(
        array('message' => 'Author Not Created'));
}
