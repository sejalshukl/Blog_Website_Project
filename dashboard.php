<?php
include('header.php');
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user's posts excluding drafts
$user_id = $_SESSION['user_id'];

// Fetch user's published posts (excluding drafts)
$stmt = $conn->prepare("
    SELECT * FROM posts 
    WHERE user_id = :user_id 
    AND id NOT IN (SELECT post_id FROM drafts WHERE user_id = :user_id)
");
$stmt->execute([':user_id' => $user_id]);
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user's drafts with post details
$stmt = $conn->prepare("
    SELECT d.post_id, d.user_id, p.title, p.content 
    FROM drafts d 
    JOIN posts p ON d.post_id = p.id 
    WHERE d.user_id = :user_id
");
$stmt->execute([':user_id' => $user_id]);
$drafts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Your Dashboard</h1>
        <a href="create_post.php">Create New Post</a>

        <h2>Your Blog Posts</h2>
        <?php if (empty($posts)): ?>
            <p>No posts found. <a href="create_post.php">Create a new post!</a></p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p>
                        <?php 
                        // Display only the first 150 characters of the content
                        $content = $post['content']; 
                        echo (strlen($content) > 150) ? (substr($content, 0, 150) . '...') : ($content); 
                        ?>
                    </p>
                    <a href="edit_post.php?id=<?php echo $post['id']; ?>">Edit</a>
                    <a href="delete_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <h2>Your Drafts</h2>
        <?php if (empty($drafts)): ?>
            <p>No drafts found.
        <?php else: ?>
            <?php foreach ($drafts as $draft): ?>
                <div class="draft">
                    <h3><?php echo htmlspecialchars($draft['title']); ?></h3>
                    <p>
                        <?php 
                        // Display only the first 150 characters of the draft content
                        $draft_content = $draft['content']; 
                        echo (strlen($draft_content) > 150) ? (substr($draft_content, 0, 150) . '...') : ($draft_content); 
                        ?>
                    </p>
                    <a href="edit_draft.php?id=<?php echo $draft['post_id']; ?>">Edit Draft</a>
                    <a href="delete_draft.php?id=<?php echo $draft['post_id']; ?>" onclick="return confirm('Are you sure?')">Delete Draft</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
