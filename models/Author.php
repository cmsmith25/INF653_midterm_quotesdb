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

    public function exists($author_id) {
        $query = 'SELECT id FROM ' . $this->table . '
        WHERE id = :author_id LIMIT 1';

        //Prepare query
        $stmt = $this->conn->prepare($query);

        //Bind parameter
        $stmt->bindParam(':author_id', $author_id);

        //Execute query
        $stmt->execute();

        //Check if author exists
        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
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
    public function read_single() {
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
        $stmt->bindParam(1, $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

       if ($row) {
        $this->id = $row['id'];
        $this->author = $row['author'];

            return array(
                'id' => $this->id,
                'author' => $this->author
            );
       } else {
            return false;
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
            }
        } else {
            return false;
        }
    }
}





   


