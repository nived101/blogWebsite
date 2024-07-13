<?php
include('conn.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['signin'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            
            $cookie_name = 'user_email';
            $cookie_value = $email;
            $cookie_expiry = time() + (86400 * 30); // 30 days validity
            $cookie_path = '/'; // available across the entire domain

            setcookie($cookie_name, $cookie_value, $cookie_expiry, $cookie_path);

            
            // $cookie_name = 'user_username';
            // $cookie_value = $row['username'];
            // setcookie($cookie_name, $cookie_value, $cookie_expiry, $cookie_path);

            header('Location: index.php'); // Redirect to homepage or another page
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            height: 100vh;
            margin: 0;
        }

        .field {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .heading {
            text-align: center;
            margin-bottom: 20px;
        } 

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .formField {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background: #0056b3;
        }

        small {
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
    <title>Sign In</title>
</head>
<body>
    <?php include('navbar.php'); ?>
    <h1 class="heading">Sign In</h1>
    
    <div class="field">
        <form action="signin.php" method="POST">
            <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
            <input type="email" class="formField" placeholder="Email" name="email" required>
            <input type="password" class="formField" placeholder="Password" name="password" required>
            <input type="submit" class="btn" value="Sign In" name="signin">
            <small>Don't have an account? <a href="register.php">Register</a></small>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>


