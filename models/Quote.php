<?php
class Quote {
    // Database connection and table name
    private $conn;
    private $table = 'quotes';

    // Object properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Joined properties
    public $author;    // Author name
    public $category;  // Category name

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    // Read all quotes with LEFT JOIN to get author and category names
    public function readAll(){
        $query = "SELECT 
                    q.id, 
                    q.quote, 
                    COALESCE(a.author, '') AS author, 
                    COALESCE(c.category, '') AS category
                  FROM " . $this->table . " q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  ORDER BY q.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read filtered quotes by author_id and/or category_id using LEFT JOIN
    public function readFiltered($author_id = null, $category_id = null){
        $query = "SELECT 
                    q.id, 
                    q.quote, 
                    COALESCE(a.author, '') AS author, 
                    COALESCE(c.category, '') AS category
                  FROM " . $this->table . " q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id";
        $conditions = array();
        if($author_id){
            $conditions[] = " q.author_id = :author_id ";
        }
        if($category_id){
            $conditions[] = " q.category_id = :category_id ";
        }
        if(count($conditions) > 0){
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
        $query .= " ORDER BY q.id ASC";
        $stmt = $this->conn->prepare($query);
        if($author_id){
            $stmt->bindParam(':author_id', $author_id);
        }
        if($category_id){
            $stmt->bindParam(':category_id', $category_id);
        }
        $stmt->execute();
        return $stmt;
    }

    // Read a single quote by id using LEFT JOIN
    public function read_single(){
        $query = "SELECT 
                    q.id, 
                    q.quote, 
                    COALESCE(a.author, '') AS author, 
                    COALESCE(c.category, '') AS category
                  FROM " . $this->table . " q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1 OFFSET 0";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            return true;
        } else{
            return false; // No data found
        }
    }
    
    // Create a new quote
    public function create(){
        $query = 'INSERT INTO ' . $this->table . ' (quote, category_id, author_id)
                  VALUES (:quote, :author_id, :category_id)';
        $stmt = $this->conn->prepare($query);
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        if($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Update an existing quote
    public function update(){
        $query = 'UPDATE ' . $this->table . '
                  SET quote = :quote, author_id = :author_id, category_id = :category_id
                  WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        if($stmt->execute()){
            return ($stmt->rowCount() > 0);
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Delete a quote
    public function delete(){
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return ($stmt->rowCount() > 0);
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
?>
