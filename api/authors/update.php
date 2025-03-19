<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';
include_once '../../models/Quote.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Get raw author data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$author->id = $data->id;


$author->id = $data->id;
$author->author = $data->author;

//Update author
if($author->update()) {
    echo json_encode(
    array('message' => 'Author Updated')
);
} else {
    echo json_encode(
        array('message' => 'Author Not Updated')
    );
}