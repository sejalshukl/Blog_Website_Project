<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch post data
$post_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = :id AND user_id = :user_id");
$stmt->execute([':id' => $post_id, ':user_id' => $_SESSION['user_id']]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Post not found.");
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    if (empty($title) || empty($content)) {
        $error = "Title and Content are required.";
    } else {
        // Update the post in the database
        $stmt = $conn->prepare("UPDATE posts SET title = :title, content = :content, tags = :tags WHERE id = :id");
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':tags' => $tags,
            ':id' => $post_id
        ]);

        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <style>
        /* General Body Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #E0F6F5; /* Very Light Teal */
            margin: 0;
            padding: 20px; /* Add padding around the body */
        }

        /* Form Container Styles */
        form {
            max-width: 700px; /* Maximum width of the form */
            margin: auto; /* Center the form */
            background-color: #ffffff; /* White background for the form */
            padding: 20px; /* Padding inside the form */
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            animation: fadeIn 0.5s; /* Animation for the form appearance */
        }

        /* Input and Textarea Styles */
        input[type="text"],
        textarea {
            width: 97%; /* Full width */
            padding: 10px; /* Padding inside input/textarea */
            border: 1px solid #007B7F; /* Teal border color */
            border-radius: 5px; /* Rounded corners */
            margin-bottom: 15px; /* Space below each input */
        }

        /* Button Styles */
        button {
            padding: 10px 15px; /* Padding for the button */
            background-color: #007B7F; /* Teal Blue background */
            color: white; /* White text */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.3s; /* Smooth background change */
        }

        button:hover {
            background-color: #005e5f; /* Darker Teal on hover */
        }

        /* Error Message Styles */
        .error {
            color: #FF6347; /* Tomato color for error messages */
            margin-bottom: 15px; /* Space below error message */
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            body {
                padding: 10px; /* Reduced padding for smaller screens */
            }
        }
    </style>
    <script src="https://cdn.tiny.cloud/1/8nc1irym3fuov7sz95hrf6qg07xv0xuumcyt4yeznykkso5i/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'image link lists',
            toolbar: 'undo redo | bold italic | link image | alignleft aligncenter alignright | bullist numlist',
            automatic_uploads: true,
            height: 300,
            image_advtab: true, // This allows for advanced image options, including alignment
            setup: function (editor) {
                editor.on('init', function () {
                    editor.getDoc().body.style.fontSize = '14px'; // Adjust body font size if needed
                });
            },
        });
    </script>
</head>
<body>
    <h1>Edit Blog Post</h1>
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="edit_post.php?id=<?php echo $post_id; ?>" method="POST">
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        <textarea id="content" name="content"><?php echo htmlspecialchars($post['content']); ?></textarea>
        <input type="text" name="tags" value="<?php echo htmlspecialchars($post['tags']); ?>">
        <button type="submit" name="update">Update Post</button>
    </form>
</body>
</html>
