<?php
include('conn.php');

$firstname = $lastname = $username = $email = $createpassword = $confirmpassword = "";
$errors = [];

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $createpassword = mysqli_real_escape_string($conn, $_POST['createpassword']);
    $confirmpassword = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
  
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Username already exists.";
    }
    
    if ($createpassword !== $confirmpassword) {
        $errors[] = "Passwords do not match.";
    }
    
    $avatar = $_FILES['avatar']['name'];
    $avatar_tmp = $_FILES['avatar']['tmp_name'];
    $avatar_folder = 'uploads/' . $avatar;

    if (empty($errors)) {
        $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

        if (!empty($avatar)) {
            if (move_uploaded_file($avatar_tmp, $avatar_folder)) {
                $query = "INSERT INTO users (firstname, lastname, username, email, password, avatar) 
                          VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo '<p class="alert__message success">Registration successful!</p>';
                } else {
                    echo '<p class="alert__message error">Error: ' . mysqli_error($conn) . '</p>';
                }
            } else {
                $errors[] = "Failed to upload avatar.";
            }
        } else {
            $query = "INSERT INTO users (firstname, lastname, username, email, password) 
                      VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo '<p class="alert__message success">Registration successful!</p>';
            } else {
                echo '<p class="alert__message error">Error: ' . mysqli_error($conn) . '</p>';
            }
        }
    } else {
        foreach ($errors as $error) {
            echo '<p class="alert__message error">' . $error . '</p>';
        }
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
  align-items: center;
  height: 100vh;
  margin: 0;
}

.heading {
  text-align: center;
  margin-bottom: 20px;
}

.form__section {
  display: grid;
  place-items: center;
  height: 100vh;
  margin: 5rem 0;
}

.field {
  display: flex;
  justify-content: center;
  align-items: center;
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
  transition: background 0.3s ease;
}

.btn:hover {
  background: #0056b3;
}

.form__control {
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.form__section small {
  margin-top: 1rem;
  display: block;
}

.form__section small a {
  color: var(--color-primary);
  margin-left: 1rem;
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

input, textarea, select {
  padding: 0.8rem 1.4rem;
  background-color: var(--color-gray-900);
  border-radius: var(--card-border-radius-2);
  resize: none;
  color: var(--color-white);
}


    </style>
    <title>Register</title>
</head>
<body>
    <?php include('navbar.php'); ?>
    <h1 class="heading">Register</h1>
    <div class="field">
        <form action="register.php" enctype="multipart/form-data" method="POST">
            <input type="text" class="formField" name="firstname" value="<?= htmlspecialchars($firstname) ?>" placeholder="First Name">
            <input type="text" class="formField" name="lastname" value="<?= htmlspecialchars($lastname) ?>" placeholder="Last Name">
            <input type="text" class="formField" name="username" value="<?= htmlspecialchars($username) ?>" placeholder="Username">
            <input type="email" class="formField" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Email">
            <input type="password" class="formField" name="createpassword" value="<?= htmlspecialchars($createpassword) ?>" placeholder="Password">
            <input type="password" class="formField" name="confirmpassword" value="<?= htmlspecialchars($confirmpassword) ?>" placeholder="Confirm Password">
            <div class="form__control">
                <br>
                <br>
                <label for="avatar">User Avatar</label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Register</button> 
            <small>Already have an account? <a href="signin.php">Sign in</a></small>
        </form>
    </div>
    <?php include('footer.php'); ?>
</body>
</html>

sigin

<?php
include('conn.php');

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