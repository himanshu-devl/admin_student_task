<?php
session_start();


include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];


    $query = "SELECT `id`, `username`, `password`, `role` FROM `users` WHERE `username`='$username' AND `password`='$password'";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $_SESSION["user_id"] = $row['id'];
    $_SESSION["username"] = $row['username'];
    $_SESSION["role"] = $row['role'];

    
        header("Location: dashboard.php");
}
?>
