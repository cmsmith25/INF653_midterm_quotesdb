<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

//Check if the id is provided
if (isset($data->id)) {
//Set ID to delete
$quote->id = $data->id;

//Delete quote
if ($quote->delete()) {
    echo json_encode(
        array('message' => 'Quote Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Quote Not Deleted')
    );
}
} else {
    //Handles case if id is not provided
    echo json_encode(
        array('message' => 'ID not provided for delete'));
    }