<?php

header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    include_once 'Database.php';
    include_once 'Quote.php';

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

        //Create a DB connection
        $database = new Database();
        $db = $database->connect();
    
        //Instantiate Author model
        $quote = new Quote($db);
    
        //Handle Get request
        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $quote->id = $_GET['id'];
                $quote_data = $quote->getSingleQuote();
    
                if($quote_data) {
                    echo json_encode($quote_data);
                } else {
                    echo json_encode(["message" => "Quote not found"]);
            } else {
                $quote_data = $quote->getAllQuotes();
            }
        }
    
        elseif ($method === 'POST') {
            $data = json_decode(file_get_contents("php://input"));

            if (!empty($data->author) && !empty($data->text)) {
                $quote->author = $data->author;
                $quote->text = $data->text;

                if($quote->create()) {
                    echo json_encode(["message" => "Quote Created Successfully"]);
                } else {
                    echo json_encode(["message" => "Failed to create quote"]);
                }
            } else {
                echo json_encode(["message"] => "Incomplete data");
                }
            }

        // Handle PUT request (update a quote)
        elseif ($method === 'PUT') {
            $data = json_decode(file_get_contents("php://input"));

            if (isset($data->id) && !empty($data->author) && !empty($data->text)) {
                $quote->id = $data->id;
                $quote->author = $data->author;
                $quote->text = $data->text;

                if ($quote->update()) {
                    echo json_encode(["message" => "Quote updated successfully"]);
                } else {
                    echo json_encode(["message" => "Failed to update quote"]);
                }
        } else {
            echo json_encode(["message" => "Incomplete data"]);
        }
    }

        // Handle DELETE request
        elseif ($method === 'DELETE') {
            $data = json_decode(file_get_contents("php://input"));

            if (isset($data->id)) {
                $quote->id = $data->id;

                if ($quote->delete()) {
                    echo json_encode(["message" => "Quote deleted successfully"]);
                } else {
                  echo json_encode(["message" => "Failed to delete quote"]);
                }
        } else {
            echo json_encode(["message" => "Missing quote ID"]);
    }
}
