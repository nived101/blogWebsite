<?php
include('conn.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

$email = $_SESSION['email'];

$query = "SELECT id, title, content, image, created_at FROM blogs WHERE email = '$email' ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

$blogs = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }
}

echo json_encode($blogs);
?>
