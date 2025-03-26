<?php
    class Author{
        //DB Stuff
        private $conn;
        private $table = 'authors';

        //Author Properties
        public $id;
        public $author;

        // Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get Authors
        public function read(){
            //Create query
            $query = 'SELECT 
                        id,
                        author
                    FROM
                    ' . $this->table . '';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        //Get Single Author
        public function read_single(){
            //Create query
            $query = 'SELECT 
                        id,
                        author
                    FROM
                ' . $this->table . '
                WHERE
                id = ?
            LIMIT 1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Bind Id
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set Properties
            if(isset($row['id'])&& isset($row['author'])){
                $this->id = $row['id'];
                $this->author = $row['author'];
              }
        }

        //Create Author
        public function create(){
            // Create Query
            $query = 'INSERT INTO ' .
                    $this->table . '
                (
                author)
                VALUES
                    (
                    :author)
                RETURNING id, author';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Data
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()){
                return $stmt->fetch()["id"];
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        //Update Author
        public function update(){
            // Update Query
            $query = 'UPDATE ' .
            $this->table . '
        SET
            author = :author
            WHERE
                id = :id';
                

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind Data
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':id', $this->id);
            
            // Execute query
            if($stmt->execute()){
                return true;
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        //Delete Author
        public function delete(){
            //Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()){
                return true;
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

}