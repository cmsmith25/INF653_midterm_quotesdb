<?php


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

 //Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 //Instantiate category object
 $category = new Category($db);

 //Category query
 $result = $category->read();

 // Get row count
 $num = $result->rowCount();

 //Check if any authors
 if($num > 0) {
    $categories_arr = array();

    //Loop through results and fetch category data
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        //Create array for category
        $category_item = array(
            'id' => $id,
            'category' => $category
        );

        //Push to "data"
        array_push($categories_arr, $category_item);
    }

    //Turn to JSON
    echo json_encode($categories_arr);

 } else {
    echo json_encode(
        array('message' => 'No Categories Found')
    );

 }

