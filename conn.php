<?php 
   $serverName = "localhost";
   $userName = "root";
   $password = "";
   $dataBase = "blog";

$conn = mysqli_connect($serverName, $userName, $password, $dataBase);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
