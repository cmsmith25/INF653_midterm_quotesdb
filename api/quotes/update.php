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
//if (isset($data->id) && isset($data->quote) && isset($data->author_id) && isset($data->category_id)) {
//Set ID to update
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//Update quote
if($quote->update()) {
    echo json_encode(
    array("id" => $quote->id,
          "quote" => $quote->quote,
          "author_id" => $author_id->author_id,
          "category_id" => $category_id->category_id,
           "message" => "No Quotes Found"));

} else {
    echo json_encode(
        array('message' => 'Quote Not Missing Required Parameters'));

    }

