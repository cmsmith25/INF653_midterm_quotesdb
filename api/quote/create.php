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

if (!empty($data->quote) && is_numeric($data->category_id) && is_numeric($data->author_id)) {    
//Set the properties of quote
$quote->quote = $data->quote;
$quote->category_id = (int) $data->category_id;
$quote->author_id = (int) $data->author_id;

//Create quote
if ($quote->create()) {
    echo json_encode(array('message' => 'Quote Created'));
} else {
    echo json_encode(
        array('message' => 'Quote Not Created'));
}
} else {
    echo json_encode(array('message' => 'Invalid data input'));
}