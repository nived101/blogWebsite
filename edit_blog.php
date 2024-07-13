<?php
// Check if a session is not already active before starting it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include your database connection file here or ensure $conn is initialized
include('conn.php');

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Query to fetch the blog post details
    $query = "SELECT * FROM blogs WHERE id = $blog_id AND email = '{$_SESSION['email']}'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $blog = mysqli_fetch_assoc($result);

        // Handle form submission for editing
        if (isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);

            // Update query
            $update_query = "UPDATE blogs SET title = '$title', content = '$content' WHERE id = $blog_id";
            $update_result = mysqli_query($conn, $update_query);

            if ($update_result) {
                echo '<script>alert("Blog updated successfully!"); window.location.href = "blogs.php?id=' . $blog_id . '";</script>';
                exit();
            } else {
                echo '<script>alert("Error updating blog. Please try again later.")</script>';
            }
        }
    } else {
        echo '<p>Blog not found or you do not have permission to edit it.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <title>Edit Blog</title>
</head>
<body>
    <?php include('navbar.php'); ?>

    <section class="postBlog">
        <h1 class="heading">Edit Blog</h1>
        <form action="" method="POST">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>"><br><br>
            
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="10"><?php echo htmlspecialchars($blog['content']); ?></textarea><br><br>
            
            <input type="submit" name="submit" value="Update">
        </form>
    </section>

    <?php include('footer.php'); ?>
</body>
</html>
