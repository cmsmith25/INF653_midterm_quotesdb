<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../config/Database.php';
include_once '../../models/Author.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate author object
$author = new Author($db);

//Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : null;

$author_data = null;

if ($author->id) {
    $author_data = $author->read_single();
} else {
    echo json_encode(array("message" => "Missing Required Parameters"));
}

if ($author_data) {
    echo json_encode($author_data);
} else {
    //If no record is found for ID
    echo json_encode(["message" => "author_id Not Found"]);
}
?>


