<?php
session_start();
include('config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        $error = "Title and Content are required.";
    } else {
        // Check if there is an existing draft for this user
        $stmt = $conn->prepare("SELECT post_id FROM drafts WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':user_id' => $user_id]);
        $draft = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($draft) {
            // If a draft exists, update the corresponding post in the 'posts' table
            $post_id = $draft['post_id'];
            $stmt = $conn->prepare("UPDATE posts SET title = :title, content = :content, tags = :tags WHERE user_id = :user_id AND id = :post_id");
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':tags' => $tags,
                ':user_id' => $user_id,
                ':post_id' => $post_id
            ]);

            // After updating, delete the draft entry
            $stmt = $conn->prepare("DELETE FROM drafts WHERE user_id = :user_id AND post_id = :post_id");
            $stmt->execute([
                ':user_id' => $user_id,
                ':post_id' => $post_id
            ]);

        } else {
            // If no draft exists, insert a new post
            $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags) VALUES (:user_id, :title, :content, :tags)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':title' => $title,
                ':content' => $content,
                ':tags' => $tags
            ]);

            // Get the post ID of the newly created post
            $post_id = $conn->lastInsertId();
        }

        // Redirect to the dashboard after saving/updating the post
        header("Location: dashboard.php");
        exit;
    }
}

if (isset($_POST['save_draft'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        $error = "Title and Content are required.";
    } else {
        // Check if a draft exists for this user
        $stmt = $conn->prepare("SELECT post_id FROM drafts WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([':user_id' => $user_id]);
        $draft = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($draft) {
            // If a draft exists, update the corresponding post in the 'posts' table
            $post_id = $draft['post_id'];
            $stmt = $conn->prepare("UPDATE posts SET title = :title, content = :content, tags = :tags WHERE id = :post_id AND user_id = :user_id");
            $stmt->execute([
                ':title' => $title,
                ':content' => $content,
                ':tags' => $tags,
                ':post_id' => $post_id,
                ':user_id' => $user_id
            ]);

        } else {
            // If no draft exists, insert a new post and create a draft entry
            $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, tags) VALUES (:user_id, :title, :content, :tags)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':title' => $title,
                ':content' => $content,
                ':tags' => $tags
            ]);

            // Get the post ID of the newly created post
            $post_id = $conn->lastInsertId();

            // Insert into the drafts table
            $stmt = $conn->prepare("INSERT INTO drafts (user_id, post_id) VALUES (:user_id, :post_id)");
            $stmt->execute([
                ':user_id' => $user_id,
                ':post_id' => $post_id
            ]);
        }

        // Redirect to the dashboard after saving/updating the draft
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
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
#autosave-message {
    position: fixed; /* Fix the message in the viewport */
    top: 20px; /* 20px from the top */
    right: 20px; /* 20px from the right */
    background-color: rgba(0, 128, 0, 0.9); /* Green background with transparency */
    color: white; /* White text */
    padding: 10px 20px; /* Padding for spacing */
    border-radius: 5px; /* Rounded corners */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    font-weight: bold; /* Bold text */
    display: none; /* Hidden by default */
    z-index: 1000; /* Make sure it's on top of other elements */
}

/* Responsive Design */
@media (max-width: 600px) {
    body {
        padding: 10px; /* Reduced padding for smaller screens */
    }
}
    </style>
</head>
<body>
    <h1>Create New Blog Post</h1>
    
    <?php if (isset($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form action="create_post.php" method="POST">
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea id="content" name="content" placeholder="Write your content here..."></textarea>
        <input type="text" name="tags" placeholder="Tags (optional)">
        <button type="submit" name="create">Create Post</button>
        <button type="submit" name="save_draft" style="background-color: #007bff;">Save as Draft</button>
    </form>
    <div id="autosave-message" ></div>
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
<script>
    let postId = null; // Track the post ID after first autosave
    const autosaveMessage = document.getElementById('autosave-message'); // Get the autosave message element

    function showAutosaveMessage(message, isError = false) {
        // Display the message
        autosaveMessage.textContent = message;
        autosaveMessage.style.color = isError ? 'red' : 'green'; // Change color based on error or success
        autosaveMessage.style.display = 'block';

        // Hide the message after 3 seconds
        setTimeout(() => {
            autosaveMessage.style.display = 'none';
        }, 3000);
    }

    function autosave() {
        const title = document.querySelector('input[name="title"]').value;
        const content = tinymce.get('content').getContent();
        const tags = document.querySelector('input[name="tags"]').value;

        if (title.trim() === '' || content.trim() === '') {
            console.log("Autosave skipped: Title or content is empty.");
            return; // Skip autosave if title or content is empty
        }

        // Send an AJAX request to the autosave endpoint
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "autosave.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    postId = response.post_id; // Update postId after first autosave
                    showAutosaveMessage("Autosaved successfully.");
                    console.log("Autosave successful for post ID: " + postId);
                } else {
                    showAutosaveMessage(response.error || "Autosave failed.", true);
                    console.error(response.error || "Autosave failed.");
                }
            }
        };

        const params = `title=${encodeURIComponent(title)}&content=${encodeURIComponent(content)}&tags=${encodeURIComponent(tags)}`;
        if (postId) {
            xhr.send(`${params}&post_id=${postId}`);
        } else {
            xhr.send(params);
        }
    }

    // Autosave every 10 seconds
    setInterval(autosave, 30000);
</script>


</html>
