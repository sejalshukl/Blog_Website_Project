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

// Fetch the draft details
if ($post_id) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("
        SELECT d.post_id, d.user_id, p.title, p.content, p.tags 
        FROM drafts d 
        JOIN posts p ON d.post_id = p.id 
        WHERE d.post_id = :post_id AND d.user_id = :user_id
    ");

    $stmt->execute([':post_id' => $post_id, ':user_id' => $user_id]);
    $draft = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if draft exists
    if (!$draft) {
        echo "Draft not found.";
        exit;
    }
} else {
    echo "Invalid post ID.";
    exit;
}

// Handle form submission for updating the post
if (isset($_POST['update_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // Update the post in the posts table
    $stmt = $conn->prepare("
        UPDATE posts SET title = :title, content = :content, tags = :tags 
        WHERE id = :post_id AND user_id = :user_id
    ");
    $stmt->execute([':title' => $title, ':content' => $content, ':tags' => $tags, ':post_id' => $post_id, ':user_id' => $user_id]);

    // Optionally, delete the draft after updating the post
    $stmt = $conn->prepare("DELETE FROM drafts WHERE post_id = :post_id AND user_id = :user_id");
    $stmt->execute([':post_id' => $post_id, ':user_id' => $user_id]);

    // Redirect to the dashboard or posts page
    header("Location: dashboard.php");
    exit;
}

// Handle form submission for saving a draft
if (isset($_POST['save_draft'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // Update the post in the posts table
    $stmt = $conn->prepare("
        UPDATE posts SET title = :title, content = :content, tags = :tags 
        WHERE id = :post_id AND user_id = :user_id
    ");
    $stmt->execute([':title' => $title, ':content' => $content, ':tags' => $tags, ':post_id' => $post_id, ':user_id' => $user_id]);

    // Redirect back to the edit page or show a message
    header("Location: edit_draft.php?id=" . $post_id . "&saved=1");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Draft</title>
    <link rel="stylesheet" href="style.css">
    <style>
    /* Basic Reset */
    body {
        font-family: Arial, sans-serif;
        background-color: #E0F6F5; /* Very Light Teal Background */
        margin: 0; /* Reset default margin */
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff; /* White background for the container */
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #007B7F; /* Teal color for headings */
    }

    .container form {
        display: flex;
        flex-direction: column;
    }

    input[type="text"],
    textarea {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #007B7F; /* Teal border color */
        border-radius: 4px;
        font-size: 16px;
        resize: vertical; /* Allows vertical resizing of the textarea */
    }

    textarea {
        height: 200px; /* Set a default height for the textarea */
    }

    /* Button Styles */
    .container button {
        padding: 10px 15px;
        background-color: #007B7F; /* Teal Blue background */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .container button:hover {
        background-color: #005e5f; /* Darker Teal on hover */
    }

    /* Link Styles */
    a {
        margin-top: 15px;
        text-decoration: none;
        color: #007B7F; /* Teal color for links */
        font-size: 16px;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>
    <div class="container">
        <h1>Edit Draft</h1>
        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($draft['title']); ?>" required>

            <label for="content">Content:</label>
            <textarea name="content" id="content" required><?php echo htmlspecialchars($draft['content']); ?></textarea>

            <label for="tags">Tags:</label>
            <input type="text" name="tags" id="tags" value="<?php echo htmlspecialchars($draft['tags']); ?>" required>

            <button type="submit" name="update_post" id="update_post" style="margin-bottom: 10px;">Update Post</button>
            <button type="submit" id='save_draft' name='save_draft'>Save Draft</button>
        </form>
        <a href="dashboard.php">Cancel</a> <!-- Redirect to dashboard -->
    </div>
</body>
<script src="https://cdn.tiny.cloud/1/8nc1irym3fuov7sz95hrf6qg07xv0xuumcyt4yeznykkso5i/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'image link lists',
        toolbar: 'undo redo | bold italic | link image | alignleft aligncenter alignright | bullist numlist',
        automatic_uploads: true,
        height: 300,
        image_advtab: true, // This allows for advanced image options, including alignment
        // Additional configuration for image alignment
        setup: function (editor) {
            editor.on('init', function () {
                editor.getDoc().body.style.fontSize = '14px'; // Adjust body font size if needed
            });
        },
    });
</script>
</html>
