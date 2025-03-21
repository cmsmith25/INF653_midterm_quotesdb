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

$id = isset($_GET['id']) ? $_GET['id'] : die ();

//Set the ID
$quote->id = $id;

//Delete the quote
if ($quote->delete()) {
    echo json_encode(array(
        'id' => $id)
);

} else {
    echo json_encode(
        array('message' => 'No Quotes Found',
        'id' => $id
    ));
}