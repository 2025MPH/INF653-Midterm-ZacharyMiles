<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read function: returns all authors ordered by id ascending
    public function read(){
        $query = "SELECT id, author FROM " . $this->table . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read single author by id; sets the properties if found.
    public function read_single(){
        $query = "SELECT id, author FROM " . $this->table . " WHERE id = :id LIMIT 1 OFFSET 0";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->author = $row['author'];
            return true;
        } else {
            return false;
        }
    }

    // Create a new author
    public function create() {
        $query = "INSERT INTO " . $this->table . " (author) VALUES (:author)";
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $stmt->bindParam(':author', $this->author);
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    
    // Update an existing author
    public function update(){
        $query = "UPDATE " . $this->table . " SET author = :author WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete an author
    public function delete(){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>
