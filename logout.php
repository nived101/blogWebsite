<?php
// Clear user-related cookies
setcookie('user_email', '', time() - 3600, '/');

// setcookie('user_username', '', time() - 3600, '/');

// Redirect to the homepage or another page after logout
header('Location: index.php');
exit;
?>
