<?php

class Author {
    //DB stuff
    private $conn;
    private $table = 'authors';


    //Author properties
    public $id;
    public $author;
   


    //Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get Authors
    public function read() {
        //Create query
        $query = 'SELECT
            a.id,
            a.author
            FROM 
            ' . $this->table . ' a
            ORDER BY
            a.id DESC';
    
    
            
    //Prepare statement
   $stmt = $this->conn->prepare($query);
   
    //Execute query
   $stmt->execute();

   return $stmt;
}

    //Get a single author
    public function read_single($id) {
        //Create query
        $query = 'SELECT
        a.id,
        a.author
        FROM
        ' . $this->table . ' a
        WHERE
            a.id = ?';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);
        
        //Bind ID
        $stmt->bindParam(1, $id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        } else {
            return false; //If no result is found
        }

    }


    //Create author
    public function create() {
        //Create query
        $query = 'INSERT INTO ' . $this->table . ' 
        (author) VALUES (:author)';
            
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
    
        //Bind data
        $stmt->bindParam(':author', $this->author);
    
        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }
}

    //Update author
    public function update() {
        //create query
        $query = 'UPDATE ' . $this->table . '
        SET
            id = :id,
            author = :author
        WHERE
          id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->author = htmlspecialchars(strip_tags($this->author));
     
        //Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);
     
       //Execute query
        if($stmt->execute()) {
            return true;
    
        } else {

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }
}

    //Delete author
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
        } else {
            printf("Error: Category not found.\n");
            return false;
        }
        } else {

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
}





   


