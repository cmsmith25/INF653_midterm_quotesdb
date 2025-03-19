<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';
include_once '../../models/Quote.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate category object
$quote = new Quote($db);

//Get ID
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get category
$quote->read_single();

//Create array
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote
);

//Make JSON
print_r(json_encode($quote_arr));