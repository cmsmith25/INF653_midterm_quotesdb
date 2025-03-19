
<?php


header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];


    include_once 'Database.php';
    include_once 'Category.php';

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    // Create a database connection (assuming the Database class handles that)
    $database = new Database();
    $db = $database->connect();

    // Instantiate the Category model
    $category = new Category($db);

    // Handle GET request (fetch categories)
    if ($method === 'GET') {
        // Check if an ID is provided to fetch a specific category
        if (isset($_GET['id'])) {
            $category->id = $_GET['id'];
            $category_data = $category->getSingleCategory();
        
            if ($category_data) {
                echo json_encode($category_data);
            } else {
                echo json_encode(["message" => "Category not found"]);
            }
        } else {
            // Fetch all categories
            $category_data = $category->getAllCategories();
            echo json_encode($category_data);
        }
    }

    // Handle POST request (create a new category)
    elseif ($method === 'POST') {
        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->name) && !empty($data->description)) {
            // Set the category data
            $category->name = $data->name;
            $category->description = $data->description;

            // Create the category in the database
            if ($category->create()) {
                echo json_encode(["message" => "Category created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create category"]);
            }
        } else {
            echo json_encode(["message" => "Incomplete data"]);
        }
    }

    // Handle PUT request (update an existing category)
    elseif ($method === 'PUT') {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id) && !empty($data->name) && !empty($data->description)) {
            $category->id = $data->id;
            $category->name = $data->name;
            $category->description = $data->description;

            if ($category->update()) {
                echo json_encode(["message" => "Category updated successfully"]);
            } else {
                echo json_encode(["message" => "Failed to update category"]);
            }
        } else {
            echo json_encode(["message" => "Incomplete data"]);
        }
    }

    // Handle DELETE request (delete a category)
    elseif ($method === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->id)) {
            $category->id = $data->id;

            if ($category->delete()) {
                echo json_encode(["message" => "Category deleted successfully"]);
            } else {
                echo json_encode(["message" => "Failed to delete category"]);
            }
        } else {
            echo json_encode(["message" => "Missing category ID"]);
        }
    }