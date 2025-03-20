<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate category object
$quote = new Quote($db);

//Get ID
$id = isset($_GET['id']) ? $_GET['id'] : die(json_encode(["message" => "Missing ID parameter"]));

$quote->id = $id;

$result = $quote->read_single();

if($result) {
    echo json_encode($result);
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}