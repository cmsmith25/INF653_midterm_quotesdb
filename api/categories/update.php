<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';


//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

//Get raw category data
$data = json_decode(file_get_contents("php://input"));

//Check if required parameters are present
if (!isset($data->category) || empty($data->category)) {
    echo json_encode(array("message" => "Missing Required Parameters"));
    exit();
}

//Set ID to update
$category->id = $data->id;

//Clean category name
$category_name = strip_tags($category_name ?? '');

//Set category name to category object
$category->category = $category_name;

//Call update method
if($category->update()) {
    echo json_encode(array("id" => $category->id, "category" => $category->category));

} else {
    echo json_encode(array("message" => "Failed to update category"));
}