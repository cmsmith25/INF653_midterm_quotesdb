<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Quote object
$quote = new Quote($db);

//Get raw quote data
$data = json_decode(file_get_contents("php://input"));
    
//Set the properties of quote
$quote->quote = $data->quote;
$quote->category_id = $data->category_id;
$quote->author_id = $data->author_id;

//Create quote
if ($quote->create()) {
    echo json_encode(array('id' => $id, 'quote' => $quote, 'author_id' => $author_id, 'category_id' => $category_id, 'message' => 'Quote Created'));
} else {
    echo json_encode(
        array('message' => 'Missing Required Parameters'));
}
