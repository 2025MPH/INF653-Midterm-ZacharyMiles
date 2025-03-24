<?php
// Include the database configuration
require '../config/database.php';

try {
    // Start a transaction to ensure data consistency
    $conn->beginTransaction();

    // Insert into authors table
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
        $author_ids[] = $conn->lastInsertId(); // Store the author ID for linking
    }
    echo "Authors inserted successfully.<br>";

    // Insert into categories table
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
        $category_ids[] = $conn->lastInsertId(); // Store the category ID for linking
    }
    echo "Categories inserted successfully.<br>";

    // Insert into quotes table
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
        ["Truth is stranger than fiction, but it is because fiction is obliged to stick to possibilities; truth isn’t.", $author_ids[1], $category_ids[1]],
        ["Wrinkles should merely indicate where smiles have been.", $author_ids[1], $category_ids[1]],

        // Hamilton - Politics
        ["Those who stand for nothing fall for anything.", $author_ids[2], $category_ids[2]],
        ["A nation which can prefer disgrace to danger is prepared for a master and deserves one.", $author_ids[2], $category_ids[2]],
        ["Why has government been instituted at all? Because the passions of man will not conform to the dictates of reason and justice without constraint.", $author_ids[2], $category_ids[2]],
        ["The first duty of society is justice.", $author_ids[2], $category_ids[2]],
        ["Men give me credit for some genius. All the genius I have lies in this: when I have a subject in hand, I study it profoundly.", $author_ids[2], $category_ids[2]],

        // Angelou - Life
        ["If you don't like something, change it. If you can't change it, change your attitude.", $author_ids[3], $category_ids[3]],
        ["I've learned that people will forget what you said, people will forget what you did, but people will never forget how you made them feel.", $author_ids[3], $category_ids[3]],
        ["Nothing will work unless you do.", $author_ids[3], $category_ids[3]],
        ["Try to be a rainbow in someone's cloud.", $author_ids[3], $category_ids[3]],
        ["We may encounter many defeats, but we must not be defeated.", $author_ids[3], $category_ids[3]],

        // Confucius - Wisdom
        ["It does not matter how slowly you go as long as you do not stop.", $author_ids[4], $category_ids[4]],
        ["Our greatest glory is not in never falling, but in rising every time we fall.", $author_ids[4], $category_ids[4]],
        ["Life is really simple, but we insist on making it complicated.", $author_ids[4], $category_ids[4]],
        ["Real knowledge is to know the extent of one's ignorance.", $author_ids[4], $category_ids[4]],
        ["When it is obvious that the goals cannot be reached, don't adjust the goals, adjust the action steps.", $author_ids[4], $category_ids[4]]
    ];

    $stmt = $conn->prepare("INSERT INTO quotes (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)");
    foreach ($quotes as $quote) {
        $stmt->bindParam(':quote', $quote[0]);
        $stmt->bindParam(':author_id', $quote[1]);
        $stmt->bindParam(':category_id', $quote[2]);
        $stmt->execute();
    }
    echo "Quotes inserted successfully.<br>";

    // Commit transaction if all inserts succeed
    $conn->commit();

} catch (PDOException $e) {
    // Roll back transaction if an error occurs
    $conn->rollBack();
    echo "Insertion failed: " . $e->getMessage();
}

// Close connection
$conn = null;
?>
