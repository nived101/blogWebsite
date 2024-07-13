<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Blogs</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
    <style>
     
        .individualBlog {
            width: 30%;
            background-color: #fff;
            height: 100%;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .individualBlog img {
            width: 100%;
            height: 40vh;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .blogContent {
            padding: 10px;
        }

        .blogContent h3,
        .blogContent p,
        .blogContent b {
            margin-bottom: 5px;
        }

        .blogContent p {
            margin-bottom: 5px;
            font-size: 23px; 
            line-height: 1.6; 
        }

        .edit-btn,
        .delete-btn {
            margin-top: 10px;
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete-btn {
            background-color: #dc3545;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="blogsList">
        <h1 style="text-align: center;">All Blogs</h1>
        <div class="blogDiv">
            <?php
            $query = "SELECT blogs.id, blogs.title, blogs.content, blogs.image, users.firstname, blogs.created_at 
                      FROM blogs 
                      JOIN users ON blogs.email = users.email 
                      ORDER BY blogs.created_at DESC";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="individualBlog">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Blog Image">';
                    echo '<div class="blogContent">';
                    echo '<h3><a href="blog_detail.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a></h3>';
                    echo '<b>By ' . htmlspecialchars($row['firstname']) . ' on ' . date('d.m.Y', strtotime($row['created_at'])) . '</b>';
                    echo '<p>' . htmlspecialchars($row['content']). '</p>';

                    echo '<a href="edit_blog.php?id=' . $row['id'] . '" class="edit-btn">Edit</a>';
                    echo '<a href="delete_blog.php?id=' . $row['id'] . '" class="delete-btn">Delete</a>';
                    
                    // Check if the user is logged in and owns this blog post
                    if (isset($_SESSION['email']) && isset($row['email']) && $_SESSION['email'] === $row['email']) {
                        echo '<a href="edit_blog.php?id=' . $row['id'] . '" class="edit-btn">Edit</a>';
                        echo '<a href="delete_blog.php?id=' . $row['id'] . '" class="delete-btn">Delete</a>';
                    }
                    
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No blog posts found.</p>';
            }
            ?>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>