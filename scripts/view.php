<?php
// Database connection settings
$host = 'localhost';
$dbname = 'quotesdb';
$username = 'root';
$password = '';

// Connect to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all data
    $stmt = $conn->query("SELECT q.id, q.quote, a.author, c.category
                          FROM quotes q
                          JOIN authors a ON q.author_id = a.id
                          JOIN categories c ON q.category_id = c.id");

    // Display the data
    echo "<h2>Quotes:</h2>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Quote</th>
                <th>Author</th>
                <th>Category</th>
            </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['quote']}</td>
                <td>{$row['author']}</td>
                <td>{$row['category']}</td>
              </tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
