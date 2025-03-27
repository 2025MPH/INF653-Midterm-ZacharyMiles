<?php
// Category.php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    // Constructor with DB connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read function: returns all categories ordered by id ascending
    public function read(){
        $query = "SELECT id, category FROM " . $this->table . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Read single category by id; sets properties if found.
    public function read_single(){
        $query = "SELECT id, category FROM " . $this->table . " WHERE id = :id LIMIT 1 OFFSET 0";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->category = $row['category'];
            return true;
        } else {
            return false;
        }
    }

    // Create a new category
    public function create() {
        $query = "INSERT INTO " . $this->table . " (category) VALUES (:category)";
        $stmt = $this->conn->prepare($query);
        $this->category = htmlspecialchars(strip_tags($this->category));
        $stmt->bindParam(':category', $this->category);
        if ($stmt->execute()){
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
    
    // Update an existing category
    public function update(){
        $query = "UPDATE " . $this->table . " SET category = :category WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // Delete a category
    public function delete(){
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
?>
