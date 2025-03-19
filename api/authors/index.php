<?php


header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    include_once 'Database.php';
    include_once 'Author.php';

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    $database = new Database();
    $db = $database->connect();

    // Instantiate the Author model
    $author = new Author($db);

    // Handle GET request (fetch authors)
    if ($method === 'GET') {
        // Check if an ID is provided to fetch a specific author
        if (isset($_GET['id'])) {
            $author->id = $_GET['id'];
            $author_data = $author->getSingleAuthor();
        
            if ($author_data) {
                echo json_encode($author_data);
            } else {
                echo json_encode(["message" => "Author not found"]);
            }
        } else {
            // Fetch all authors
            $author_data = $author->getAllAuthors();
            echo json_encode($author_data);
        }
    }

    // Handle POST request (create a new author)
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->name) && !empty($data->bio)) {
            // Set the author data
            $author->name = $data->name;
            $author->bio = $data->bio;

            // Create the author in the database
            if ($author->create()) {
                echo json_encode(["message" => "Author created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create author"]);
            }
        } else {
            echo json_encode(["message" => "Incomplete data"]);
        }
    }

    // Handle PUT request (update an existing author)
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && !empty($data->name) && !empty($data->bio)) {
            $author->id = $data->id;
            $author->name = $data->name;
            $author->bio = $data->bio;

            if ($author->update()) {
                echo json_encode(["message" => "Author updated successfully"]);
            } else {
                echo json_encode(["message" => "Failed to update author"]);
            }
        } else {
            echo json_encode(["message" => "Incomplete data"]);
        }
    }

    // Handle DELETE request (delete an author)
    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id)) {
            $author->id = $data->id;

            if ($author->delete()) {
                echo json_encode(["message" => "Author deleted successfully"]);
            } else {
                echo json_encode(["message" => "Failed to delete author"]);
            }
        } else {
            echo json_encode(["message" => "Missing author ID"]);
        }
    }
    