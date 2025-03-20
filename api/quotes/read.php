<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

 //Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 //Instantiate Quote model
 $quote = new Quote($db);

 //Category query
 $result = $quote->read();

 // Get row count
 $num = $result->rowCount();

 //Check if any authors
 if ($num > 0) {
    $quotes_arr = array();
    $quotes_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'category_id' => $category_id,
            'author_id' => $author_id
        );

        //Push to "data"
        array_push($quotes_arr['data'], $quote_item);
    }

    //Turn to JSON
    echo json_encode($quotes_arr);

 } else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );

 }
