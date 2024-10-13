<?php
include('header.php');
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get post ID from the URL
$post_id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if post ID is valid
if ($post_id) {
    $user_id = $_SESSION['user_id'];

    // Prepare to delete the draft
    $stmt = $conn->prepare("DELETE FROM drafts WHERE post_id = :post_id AND user_id = :user_id");
    
    // Execute the delete statement for the draft
    if ($stmt->execute([':post_id' => $post_id, ':user_id' => $user_id])) {
        // Prepare to delete the corresponding post
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = :post_id AND user_id = :user_id");
        
        // Execute the delete statement for the post
        if ($stmt->execute([':post_id' => $post_id, ':user_id' => $user_id])) {
            // Redirect to the dashboard with success message
            header("Location: dashboard.php?message=Draft and associated post deleted successfully");
            exit;
        } else {
            echo "Error deleting the associated post. Please try again.";
        }
    } else {
        echo "Error deleting draft. Please try again.";
    }
} else {
    echo "Invalid draft ID.";
    exit;
}
?>
