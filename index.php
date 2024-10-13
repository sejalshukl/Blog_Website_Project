<?php
// Include database configuration and header (Assumed to be set up separately)
include('config.php');
include('header.php');

// Fetch all blog posts from the database
$stmt = $conn->prepare("SELECT p.* 
    FROM posts p
    LEFT JOIN drafts d ON p.id = d.post_id
    WHERE d.post_id IS NULL
    ORDER BY p.created_at DESC"); // Assuming you have a `created_at` column
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
</head>
<body>
    <div class="container" style="padding-inline:60px;">
        <h1>All Blog Posts</h1>

        <?php if (empty($posts)): ?>
            <p class="no-posts">No blog posts available.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h2><?php echo ($post['title']); ?></h2>
                    <p><?php echo (substr($post['content'], 0, 150)); ?>...</p>
                    <a href="post_details.php?id=<?php echo $post['id']; ?>">Read More</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
