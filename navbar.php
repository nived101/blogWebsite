<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('conn.php');
?>

<nav class="navigation">
    <a href="index.php">Home</a>
    <a href="index.php#about">About Us</a>
    <a href="blogs.php">Blog</a>
    <a href="index.php#contact">Contact Us</a>
    <a href="newsapi.php">News</a>
    
    


    <?php
    // Check if user_email cookie is set
    if (isset($_COOKIE['user_email'])) {
        $email = $_COOKIE['user_email'];

        // Fetch user's first name based on email
        $query = "SELECT firstname FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $firstname = htmlspecialchars($row['firstname']); // Sanitize output
            echo '<a href="my_blog.php" style="margin-left: auto;">Hello ' . $firstname . '</a>';
            echo '<a href="logout.php">Sign Out</a>';
        }
    } else {
        echo '<a href="signin.php" style="margin-left: auto;">Sign In</a>';
    }
    ?>
</nav>
