<?php

class Quote {
    //DB stuff
    private $conn;
    private $table = 'quotes';


    //Quote properties
    public $id;
    public $quote;
    public $category_id;
    public $author_id;


    //Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get Quotes
    public function read() {
        //Create query
        $query = 'SELECT
            q.id,
            q.quote,
            q.category_id,
            c.category AS category,
            a.author AS author
            FROM
              ' . $this->table . ' q
            LEFT JOIN
                categories c ON q.category_id = c.id
            LEFT JOIN
                authors a ON q.author_id = a.id
            ORDER BY
                q.category_id DESC,
                q.author_id DESC';
            
    
    //Prepare statement
   $stmt = $this->conn->prepare($query);

   //Execute query
   $stmt->execute();

   return $stmt;
}

//Get a single quote
public function read_single() {
    //Create query
    $query = 'SELECT
        q.id,
        q.quote,
        q.category_id,
        c.category AS category,
        a.author AS author
        FROM
        ' . $this->table . ' q
        LEFT JOIN
            categories c ON q.category_id = c.id
        LEFT JOIN
            authors a ON q.author_id = a.id
        WHERE
         q.id = ?';


        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return false;
    }
        return array(
            'id' => $row['id'],
            'quote' => $row['quote'],
            'author' => $row['author'],
            'category' => $row['category']
        );
}


    //Create quote
    public function create() {
    
    //Create query
    $query = 'INSERT INTO ' . $this->table . ' (quote, category_id, author_id)
    VALUES (:quote, :category_id, :author_id)';

    //Prepare statment
     $stmt = $this->conn->prepare($query);

     
    $this->quote = htmlspecialchars(strip_tags($this->quote));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->author_id = htmlspecialchars(strip_tags($this->author_id));
    

    //Bind data
    $stmt->bindParam(':quote', $this->quote);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':author_id', $this->author_id);

    
    //Execute query
    if ($stmt->execute()) {
        return true;
    }

    //Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

    }

    //Update quote
    public function update() {
        //Check if category_id and author_id are integers
        if (!is_int($this->category_id) || !is_int($this->author_id)) {
            printf("Error: Invalid category_id or author_id.\n");
            return false;
        }

    //Clean data
     $this->quote = htmlspecialchars(strip_tags($this->quote));
     $this->category_id = htmlspecialchars(strip_tags($this->category_id));
     $this->author_id = htmlspecialchars(strip_tags($this->author_id));
     
        //create query
        $query = 'UPDATE ' . $this->table . '
        SET
         quote = :quote,
         category_id = :category_id,
         author_id = :author_id
         WHERE
            id = :id';

    //Prepare statement
    $stmt = $this->conn->prepare($query);
     
 
     //Bind data
     $stmt->bindParam(':id', $this->id);
     $stmt->bindParam(':quote', $this->quote);
     $stmt->bindParam(':category_id', $this->category_id);
     $stmt->bindParam(':author_id', $this->author_id);


    //Execute query
    if ($stmt->execute()) {
        return true;
    }

    //Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;

    }

    //Delete quote
    public function delete() {
        //Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
            return true;
        }
        }

        return false;
    }
}




   


