<?php
// Set content type to HTML
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zachary Miles Midterm</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        h1, h2 { color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Zachary Miles Midterm</h1>
        <ul>
            <li><strong>GET</strong> /api/quotes/ – Retrieve all quotes</li>
            <li><strong>GET</strong> /api/quotes/?id={id} – Retrieve a specific quote</li>
            <li><strong>GET</strong> /api/quotes/?author_id={id} – Retrieve quotes by a specific author</li>
            <li><strong>GET</strong> /api/quotes/?category_id={id} – Retrieve quotes by a specific category</li>
            <li><strong>POST</strong> /api/quotes/ – Create a new quote</li>
            <li><strong>PUT</strong> /api/quotes/ – Update an existing quote</li>
            <li><strong>DELETE</strong> /api/quotes/ – Delete a quote</li>
            <!-- Similarly for authors and categories endpoints -->
        </ul>
    </div>
</body>
</html>
