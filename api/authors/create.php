<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Initialize the database connection
$database = new Database();
$db = $database->connect();

// Initialize the model
$author = new Author($db);

// Check the request method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get raw POST data
    $data = json_decode(file_get_contents("php://input"), true);

    // Ensure data is valid
    if (isset($data['author'])) {
        // Call the create method
        if ($author->create($data)) {
            echo json_encode(["message" => "Author created successfully."]);
        } else {
            echo json_encode(["message" => "Unable to create author."]);
        }
    } else {
        echo json_encode(["message" => "Invalid data."]);
    }
} else {
    echo json_encode(["message" => "Only POST method is allowed."]);
}