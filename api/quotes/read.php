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

 //Get quotes
 $result = $quote->read();

 // Get row count
 $num = $result->rowCount();

 //Check if any quotes found
 if ($num > 0) {
    $quotes_arr = array();
    $quotes_arr['data'] = array();

    //Loops through the array of quotes
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
    

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        //Push data to the array
        array_push($quotes_arr['data'], $quote_item);
    }

    //Turn to JSON
    echo json_encode($quotes_arr);

 } else {
    echo json_encode(array('data' => []));

 }
