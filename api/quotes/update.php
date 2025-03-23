<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$quote = new Quote($db);

//Get raw author data
$data = json_decode(file_get_contents("php://input"));

//Ensure that all data requirements are available
if (isset($data->id) && isset($data->quote) && isset($data->category_id) && isset($data->author_id)) {
//Set ID to update
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->category_id = $data->category_id;
$quote->author_id = $data->author_id;

//Update quote
if($quote->update()) {
    echo json_encode(
    array('message' => 'No Quotes Found'));

} else {
    echo json_encode(
        array('message' => 'Quote Not Updated'));
}
} else {
    echo json_encode(array('message' => 'Missing Required Parameters'));
}

