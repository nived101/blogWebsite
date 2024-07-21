<?php
session_start();
include('conn.php');

if (!isset($_SESSION['email'])) {
    header("Location: signin.php");
    exit();
}

$email = $_SESSION['email'];

class User {
    private $conn;
    public $firstname;
    public $lastname;
    public $username;
    public $email;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUserByEmail($email) {
        $query = "SELECT firstname, lastname, username, email, avatar FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->username = $row['username'];
            $this->email = $row['email'];
        }
    }
}

$user = new User($conn);
$user->getUserByEmail($email);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .profile-card {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            margin: 50px auto;
        }

        .profile-card h3,h2,
        .profile-card p {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>

    <div class="profile-card">
        <h2>Firstname:<?= htmlspecialchars($user->firstname) . ' ' . htmlspecialchars($user->lastname) ?></h2>
        <h3>Username:<?= htmlspecialchars($user->username) ?></h3>
        <h3>Email:<?= htmlspecialchars($user->email) ?></h3>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
