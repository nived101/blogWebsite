<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


include('conn.php');


if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    $delete_query = "DELETE FROM blogs WHERE id = $blog_id AND email = '{$_SESSION['email']}'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo '<script>alert("Blog deleted successfully!"); window.location.href = "blogs.php";</script>';
        exit();
    } else {
        echo '<script>alert("Error deleting blog. Please try again later.")</script>';
    }
}
?>