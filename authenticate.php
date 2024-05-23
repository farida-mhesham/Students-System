<?php
session_start();


$correct_username = "admin";
$correct_password = "password";


$username = $_POST['username'];
$password = $_POST['password'];


if ($username === $correct_username && $password === $correct_password) {
    
    $_SESSION['username'] = $username; 
    header("Location: table.php"); 
    exit();
} else {
    
    echo "Invalid username or password. Please try again.";
}
?>
