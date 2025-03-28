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

 //Author query
 $result = $author->read();

 // Get row count
 $num = $result->rowCount();

 //Check if any authors
 if($num > 0) {
    $authors_arr = array();

    //Loop through results and fetch author data
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        //Create array for author
        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        //Push to "data"
        array_push($authors_arr, $author_item);
    }

    //Turn to JSON
    echo json_encode($authors_arr);

 } else {
    echo json_encode(
        array('message' => 'No Authors Found')
    );

 }




