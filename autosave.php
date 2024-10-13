<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        echo json_encode(['error' => 'Title and Content are required']);
        exit;
    }

    // Check if the post already exists in the posts table
    if (isset($_POST['post_id'])) {
        $post_id = $_POST['post_id'];
        // Update the existing post
        $stmt = $conn->prepare("UPDATE posts SET title = :title, content = :content, tags = :tags WHERE id = :post_id AND user_id = :user_id");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':tags' => $tags,
            ':post_id' => $post_id,
            ':user_id' => $user_id
        ]);
    } else {
        // Insert a new post
        $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags) VALUES (:user_id, :title, :content, :tags)");
        $stmt->execute([
            ':user_id' => $user_id,
            ':title' => $title,
            ':content' => $content,
            ':tags' => $tags
        ]);
        $post_id = $conn->lastInsertId(); // Get the ID of the new post
    }

    // Check if the draft already exists for this post
    $stmt = $conn->prepare("SELECT * FROM drafts WHERE post_id = :post_id AND user_id = :user_id");
    $stmt->execute([
        ':post_id' => $post_id,
        ':user_id' => $user_id
    ]);

    if ($stmt->rowCount() > 0) {
        // Update the existing draft
        $stmt = $conn->prepare("UPDATE drafts SET created_at = NOW() WHERE post_id = :post_id AND user_id = :user_id");
        $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $user_id
        ]);
    } else {
        // Insert a new draft
        $stmt = $conn->prepare("INSERT INTO drafts (user_id, post_id, created_at) VALUES (:user_id, :post_id, NOW())");
        $stmt->execute([
            ':user_id' => $user_id,
            ':post_id' => $post_id
        ]);
    }

    echo json_encode(['success' => true, 'post_id' => $post_id]);
}
?>
