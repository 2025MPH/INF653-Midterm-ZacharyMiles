<?php
// Include the database configuration
require '../config/Database.php';

// Create the connection using your Database class
$database = new Database();
$conn = $database->connect();

if (!$conn) {
    exit("Connection failed.");
}

try {
    // Start a transaction
    $conn->beginTransaction();

    // Insert authors
    $authors = [
        'Albert Einstein',
        'Mark Twain',
        'Alexander Hamilton',
        'Maya Angelou',
        'Confucius'
    ];

    $author_ids = [];
    $stmt = $conn->prepare("INSERT INTO authors (author) VALUES (:author)");
    foreach ($authors as $author) {
        $stmt->bindParam(':author', $author);
        $stmt->execute();
        $author_ids[] = $conn->lastInsertId();
    }
    echo "Authors inserted successfully.<br>";

    // Insert categories
    $categories = [
        'Motivation',
        'Humor',
        'Politics',
        'Life',
        'Wisdom'
    ];

    $category_ids = [];
    $stmt = $conn->prepare("INSERT INTO categories (category) VALUES (:category)");
    foreach ($categories as $category) {
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        $category_ids[] = $conn->lastInsertId();
    }
    echo "Categories inserted successfully.<br>";

    // Insert quotes (5 quotes for each of the 5 authors/categories = 25 total)
    $quotes = [
        // Einstein - Motivation
        ["Life is like riding a bicycle. To keep your balance, you must keep moving.", $author_ids[0], $category_ids[0]],
        ["Imagination is more important than knowledge.", $author_ids[0], $category_ids[0]],
        ["Learn from yesterday, live for today, hope for tomorrow.", $author_ids[0], $category_ids[0]],
        ["Strive not to be a success, but rather to be of value.", $author_ids[0], $category_ids[0]],
        ["A person who never made a mistake never tried anything new.", $author_ids[0], $category_ids[0]],

        // Twain - Humor
        ["Get your facts first, then you can distort them as you please.", $author_ids[1], $category_ids[1]],
        ["The secret of getting ahead is getting started.", $author_ids[1], $category_ids[1]],
        ["Humor is mankind’s greatest blessing.", $author_ids[1], $category_ids[1]],
        ["Truth is stranger than fiction.", $author_ids[1], $category_ids[1]],
        ["Wrinkles should merely indicate where smiles have been.", $author_ids[1], $category_ids[1]],

        // Hamilton - Politics
        ["Those who stand for nothing fall for anything.", $author_ids[2], $category_ids[2]],
        ["A nation which can prefer disgrace to danger is prepared for a master and deserves one.", $author_ids[2], $category_ids[2]],
        ["Why has government been instituted at all? Because the passions of man will not conform to the dictates of reason.", $author_ids[2], $category_ids[2]],
        ["The first duty of society is justice.", $author_ids[2], $category_ids[2]],
        ["Men give me credit for genius. My genius lies in studying things deeply.", $author_ids[2], $category_ids[2]],

        // Angelou - Life
        ["If you don't like something, change it. If you can't change it, change your attitude.", $author_ids[3], $category_ids[3]],
        ["People will forget what you said or did, but never how you made them feel.", $author_ids[3], $category_ids[3]],
        ["Nothing will work unless you do.", $author_ids[3], $category_ids[3]],
        ["Try to be a rainbow in someone's cloud.", $author_ids[3], $category_ids[3]],
        ["We may encounter defeats, but we must not be defeated.", $author_ids[3], $category_ids[3]],

        // Confucius - Wisdom
        ["It does not matter how slowly you go as long as you do not stop.", $author_ids[4], $category_ids[4]],
        ["Our greatest glory is in rising every time we fall.", $author_ids[4], $category_ids[4]],
        ["Life is simple, but we make it complicated.", $author_ids[4], $category_ids[4]],
        ["Real knowledge is knowing the extent of your ignorance.", $author_ids[4], $category_ids[4]],
        ["When goals can't be reached, adjust action steps.", $author_ids[4], $category_ids[4]]
    ];

    $stmt = $conn->prepare("INSERT INTO quotes (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)");
    foreach ($quotes as $quote) {
        $stmt->bindParam(':quote', $quote[0]);
        $stmt->bindParam(':author_id', $quote[1]);
        $stmt->bindParam(':category_id', $quote[2]);
        $stmt->execute();
    }
    echo "Quotes inserted successfully.<br>";

    // Commit the transaction
    $conn->commit();
} catch (PDOException $e) {
    $conn->rollBack();
    echo "Insertion failed: " . $e->getMessage();
}

$conn = null;
?>
