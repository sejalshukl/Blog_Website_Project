<?php
include('config.php');

// Initialize query variable
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';

try {
    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM posts WHERE title LIKE :query OR tags LIKE :query");
    $searchQuery = "%" . $query . "%";
    $stmt->bindParam(':query', $searchQuery);
    $stmt->execute();

    // Fetch all results
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Global Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

/* Search Results Styles */
.search-results {
    padding: 20px;
    background-color: white;
    margin: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.search-results h2 {
    margin-top: 0;
}

.search-results ul {
    list-style-type: none;
    padding: 0;
}

.search-results li {
    padding: 10px;
    border-bottom: 1px solid #eaeaea;
}

.search-results li:last-child {
    border-bottom: none;
}

.search-results h3 {
    margin: 5px 0;
}

.search-results p {
    margin: 5px 0;
    line-height: 1.5;
}


.search-results a:hover {
    text-decoration: underline;
}

</style>
<body>
<?php 
    include('header.php');
?>

<div class="search-results">
    <h2>Search Results for: "<?php echo htmlspecialchars($query); ?>"</h2>
    <?php if (count($posts) > 0): ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><a style="color: black;" href="post_details.php?id=<?php echo $post['id']; ?>">
                <?php echo htmlspecialchars($post['title']); ?>
            </a></h3>
                    <p>
                    <?php 
                    // Display only the first 150 characters of the content
                    $content = $post['content']; 
                    echo (strlen($content) > 150) ? substr($content, 0, 150) . '...' : $content; 
                    ?>
                </p>
                    <p><strong>Tags:</strong> <?php echo htmlspecialchars($post['tags']); ?></p>
                    <a href="post_details.php?id=<?php echo $post['id']; ?>">Read More</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</div>
</body>
</html>
