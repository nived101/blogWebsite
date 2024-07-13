<?php
// Check if a session is not already active before starting it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection file here or ensure $conn is initialized
include('conn.php');

// Check if user is logged in
if (isset($_COOKIE['user_email'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add the provided CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .postBlog {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
        }

        .postBlog form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            max-width: 600px;
        }

        .postBlog form input[type="text"],
        .postBlog form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .postBlog form input[type="file"] {
            margin-bottom: 20px;
        }

        .postBlog form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .postBlog form input[type="submit"]:hover {
            background: #0056b3;
        }

        .alert__message {
            padding: 0.8rem 1.4rem;
            margin-bottom: 1rem;
            border-radius: var(--card-border-radius-2);
        }

        .alert__message.error {
            background: var(--color-red-light);
            color: var(--color-red);
        }

        .alert__message.success {
            background: var(--color-green-light);
            color: var(--color-green);
        }

        .alert__message.lg {
            text-align: center;
        }

        small {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
    </style>
    <title>Post Blog</title>
</head>
<body>
    <?php include('navbar.php'); ?>

    <section class="postBlog">
        <h1 class="heading">Post a Blog</h1>
        <form action="post_blog.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" class="formField" placeholder="Blog Title" required>
            <textarea name="content" class="formField" placeholder="Blog Content" rows="8" required></textarea>
            <input type="file" name="image" required>
            <input type="submit" name="submit" value="Post Blog" class="btn">
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $email = $_SESSION['email'];

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false) {
                echo '<script>alert("File is not an image.")</script>';
                exit();
            }

            if ($_FILES["image"]["size"] > 5000000) {
                echo '<script>alert("Sorry, your file is too large.")</script>';
                exit();
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';
                exit();
            }

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;

                $query = "INSERT INTO blogs (email, title, content, image) VALUES ('$email', '$title', '$content', '$image_path')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo '<script>alert("Blog updated successfully!"); window.location.href = "blogs.php?id=' . $blog_id . '";</script>';
                } else {
                    echo '<script>alert("Error posting blog. Please try again later.")</script>';
                }
            } else {
                echo '<script>alert("Sorry, there was an error uploading your file.")</script>';
            }
        }
        ?>
    </section>

    <?php include('footer.php'); ?>
</body>
</html>