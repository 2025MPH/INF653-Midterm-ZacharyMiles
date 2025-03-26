<?php
    class Category{
        //DB Stuff
        private $conn;
        private $table = 'categories';

        //Category Properties
        public $id;
        public $category;

        // Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get Categories
        public function read(){
            //Create query
            $query = 'SELECT 
                        id,
                        category
                    FROM
                    ' . $this->table . '
                    ORDER BY
                        id ASC';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        //Get Single Category
        public function read_single(){
            //Create query
            $query = 'SELECT 
                        id,
                        category
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
            if(isset($row['id'])&& isset($row['category'])){
                $this->id = $row['id'];
                $this->category = $row['category'];
            }
        }

        //Create Creatory
        public function create(){
            // Create Query
            $query = 'INSERT INTO ' .
                    $this->table . '
                (
                category)
                VALUES
                    (
                    :category)
                RETURNING id, category';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind Data
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute()){
                return $stmt->fetch()["id"];
            }else{
                // Print error if something goes wrong.
                printf("Error: %s.\n", $stmt->error);
                return false;
            }
        }

        //Update Creatory
        public function update(){
            // Update Query
            $query = 'UPDATE ' .
            $this->table . '
        SET
            category = :category
            WHERE
                id = :id';
                

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind Data
            $stmt->bindParam(':category', $this->category);
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

        //Delete Creatory
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