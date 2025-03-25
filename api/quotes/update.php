<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate objects
$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);

//Get raw author data
$data = json_decode(file_get_contents("php://input"));

//Ensure that all data requirements are available
if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array("message" => "Missing Required Parameters"));
    exit();
}


//Access Data
$author_id = $data->author_id;
$category_id = $data->category_id;
$quote_text = $data->quote;
$quote_id = $data->id;

//Check if author exists
if (!$author->exists($author_id)) {
    echo json_encode(array("message" => "author_id Not Found"));
    exit();
}

//Check if category exists
if (!$category->exists($category_id)) {
    echo json_encode(array("message" => "category_id Not Found"));
    exit();
}

//Update quote
$quote->id = $quote_id;
$quote->quote = $quote_text;
$quote->author_id = $author_id;
$quote->category_id = $category_id;

if (!$quote->exists($quote->id)) {
    echo json_encode(array("message" => "No Quotes Found"));
    exit();
}

//Update quote
if($quote->update()) {
    echo json_encode(
    array("id" => $quote->id,
          "quote" => $quote->quote,
          "author_id" => $quote->author_id,
          "category_id" => $quote->category_id));

} else {
    echo json_encode(
        array("message" => "Update Failed"));

    }

