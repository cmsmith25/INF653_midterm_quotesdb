<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Initializes my database connection
$database = new Database();
$db = $database->connect();

// Initializes the Author model
$author = new Author($db);


// Get raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Checks to see if data is valid
if (isset($data['author']['author'])) {
    // Call the create method
    if ($author->create($data)) {
         echo json_encode(["message" => "Author created successfully."]);
    } else {
        echo json_encode(["message" => "Unable to create author."]);
    }
} else {
     echo json_encode(["message" => "Invalid data."]);
}
