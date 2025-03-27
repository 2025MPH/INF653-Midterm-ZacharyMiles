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

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read quotes – supports filtering if author_id and/or category_id are set.
    // Uses LEFT JOIN so that every quote is returned even if join data is missing.
    public function read(){
        if (isset($this->author_id) && isset($this->category_id)){
            $query = "SELECT
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category
                      FROM " . $this->table . " q
                      LEFT JOIN authors a ON q.author_id = a.id
                      LEFT JOIN categories c ON q.category_id = c.id
                      WHERE q.author_id = :author_id AND q.category_id = :category_id";
        }
        else if (isset($this->author_id)){
            $query = "SELECT
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category
                      FROM " . $this->table . " q
                      LEFT JOIN authors a ON q.author_id = a.id
                      LEFT JOIN categories c ON q.category_id = c.id
                      WHERE q.author_id = :author_id";
        }
        else if(isset($this->category_id)){
            $query = "SELECT
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category
                      FROM " . $this->table . " q
                      LEFT JOIN authors a ON q.author_id = a.id
                      LEFT JOIN categories c ON q.category_id = c.id
                      WHERE q.category_id = :category_id";
        } else {
            $query = "SELECT
                        q.id,
                        q.quote,
                        a.author as author,
                        c.category as category
                      FROM " . $this->table . " q
                      LEFT JOIN authors a ON q.author_id = a.id
                      LEFT JOIN categories c ON q.category_id = c.id
                      ORDER BY q.id ASC";
        }
        
        $stmt = $this->conn->prepare($query);
        if ($this->author_id) {
            $stmt->bindParam(':author_id', $this->author_id);
        }
        if ($this->category_id) {
            $stmt->bindParam(':category_id', $this->category_id);
        }
        $stmt->execute();
        return $stmt;
    }

    // Read a single quote by id using LEFT JOIN with COALESCE so that if join data is missing,
    // default values ("Unknown") are returned.
    public function read_single(){
        $query = "SELECT 
                    q.id,
                    q.quote,
                    COALESCE(a.author, 'Unknown') AS author,
                    COALESCE(c.category, 'Unknown') AS category
                  FROM " . $this->table . " q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id       = $row['id'];
            $this->quote    = $row['quote'];
            $this->author   = $row['author'];
            $this->category = $row['category'];
            return true;
        } else {
            return false;
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
        if ($stmt->execute()){
            $this->id = $this->conn->lastInsertId();
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    // Update an existing quote (do not update the id)
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
        if ($stmt->execute()){
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
        if ($stmt->execute()){
            return ($stmt->rowCount() > 0);
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
?>
