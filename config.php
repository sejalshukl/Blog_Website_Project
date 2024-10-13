<?php
// Database connection
$host = 'localhost';
$dbname = 'blog_platform';
$user = 'root';  // Replace with your MySQL username
$pass = 'sejal@985';  // Replace with your MySQL password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}