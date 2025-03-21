<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate author object
$author = new Author($db);

//Get ID
$id = isset($_GET['id']) ? $_GET['id'] : die();


$author_data = $author->read_single($id);


    if ($author_data) {
        echo json_encode($author_data);
    } else {
        //If no record is found for ID
        echo json_encode(["message" => "author_id Not Found"]);
    }
?>


