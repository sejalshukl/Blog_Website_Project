<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$post_id = $_GET['id'];

// Delete post from database
$stmt = $conn->prepare("DELETE FROM posts WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $post_id, ':user_id' => $_SESSION['user_id']]);

header("Location: dashboard.php");
exit;
?>
