<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../../config/Database.php';
include_once '../../models/Category.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate category object
$category = new Category($db);

//Get ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get category
$category_data->read_single($id);

if ($category_data) {
    echo json_encode($category_data);
} else {
    //If no record is found for ID
    echo json_encode(["message" => "category_id Not Found"]);
}

//Make JSON
print_r(json_encode($category_arr));