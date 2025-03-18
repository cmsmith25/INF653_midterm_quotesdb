<?php

class Category {
    //DB stuff
    private $conn;
    private $table = 'categories';


    //Category properties
    public $id;
    public $category;

    //Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    //Get categories
    public function read() {
        //Create query
        $query = 'SELECT
            c.id,
            c.category
            FROM 
            ' . $this->table . ' c
            ORDER BY
            c.id DESC';
            

    //Prepare statement
   $stmt = $this->conn->prepare($query);

    //Execute query
   $stmt->execute();

   return $stmt;
}

    //Get a single category
    public function read_single() {
        //Create query
         $query = 'SELECT
        c.id,
        c.category
        FROM
        ' . $this->table . ' c
        WHERE
            c.id = ?';
        
        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1, $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

         //Set Properties
        $this->id = $row['id'];
        $this->category = $row['category'];

    }
        

    //Create category
    public function create() {
        //Create query
        $query = 'INSERT INTO ' . $this->table . '
        (category) VALUES (:category)';
            
        //Prepare statment
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->category = htmlspecialchars(strip_tags($this->category));
    
        //Bind data
        $stmt->bindParam(':category', $this->category);
    
        //Execute query
        if ($stmt->execute()) {
            return true;
        } else {
        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }
}

    //Update category
    public function update() {
        //create query
        $query = 'UPDATE ' . $this->table . '
        SET
            category = :category
        WHERE
          id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));
     
        //Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':category', $this->category);
     
       //Execute query
        if ($stmt->execute()) {
            return true;
     } else {

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }
}

    //Delete category
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
    

