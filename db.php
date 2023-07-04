<?php $servername = "localhost";
$username = "admin";
$password = "Admin@123";
$dbname = "task3";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>