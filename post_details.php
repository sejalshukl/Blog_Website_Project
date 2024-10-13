<?php
include('config.php');

// Check if the post ID is set in the URL
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

// Fetch the post from the database
$post_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = :id");
$stmt->execute([':id' => $post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the post exists
if (!$post) {
    header("Location: dashboard.php");
    exit;
}

// Format the created_at timestamp for display
$created_at = date("F j, Y, g:i a", strtotime($post['created_at']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    
    <style>
        /* General Body Styles */
        body {
            font-family: Arial, sans-serif;
        background-color: #f8b195; /* Light Peachy background for the entire body */
            margin: 0;
            padding: 0;
        }

        /* Post Container */
        .post-container {
            max-width: 800px; /* Maximum width of the post container */
            margin: 20px auto; /* Centering the container */
            padding: 20px; /* Padding inside the container */
            background-color: white;
            border-radius: 5px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        /* Post Title Styles */
        .post-container h1 {
            font-size: 2em; /* Font size for the title */
            margin-bottom: 10px; /* Space below the title */
            color: #355C7D; /* Dark blue for title */
        }

        /* Post Date Styles */
        .post-container p em {
            color: blue; /* Navy color for the publication date */
        }

        /* Post Content Styles */
        .post-content {
            margin-top: 15px; /* Space above content */
            line-height: 1.6; /* Line height for better readability */
            color: black; /* Darker gray for the text */
        }

        /* Tags Styles */
        .post-container p strong {
            margin-top: 10px; /* Space above tags */
            display: block; /* Block display for the tag section */
            font-weight: bold; /* Bold font for the tags */
            color: blue; /* Blue color for the "Tags:" label */
        }

        .post-container p span {
            color: black; /* Black color for the tag content */
        }

        /* Back Button Styles */
        .container4 a {
            display: inline-block; /* Inline block for better padding */
            margin-top: 20px; /* Space above the button */
            padding: 10px 15px; /* Padding for the button */
            background-color: blue; /* Light red background for button */
            color: white; /* Button text color */
            text-decoration: none; /* Remove underline */
            border-radius: 5px; /* Rounded corners for the button */
            transition: background-color 0.3s; /* Smooth background change on hover */
        }

        .container4 a:hover {
            background-color: #C06C84; /* Muted purple on hover */
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .post-container {
                padding: 15px; /* Reduced padding for smaller screens */
            }
            
            .post-container h1 {
                font-size: 1.5em; /* Smaller title font size */
            }
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?> <!-- Include header for navigation -->

    <div class="container4">
        <div class="post-container">
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <p><em>Published on <?php echo $created_at; ?></em></p>
            <div class="post-content">
                <?php echo nl2br($post['content']); ?>
            </div>
            <p><strong>Tags:</strong> <span><?php echo htmlspecialchars($post['tags']); ?></span></p>
        </div>
        
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<a href="dashboard.php">Back to Dashboard</a>';
        } else {
            echo '<a href="index.php">Back</a>';
        }
        ?>
    </div>
</body>
</html>
