<?php

include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];


    $query = "INSERT INTO `users`( `username`, `password`, `role`) VALUES ('$username','$password','$role')";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $password, $role);


    if (mysqli_stmt_execute($stmt)) {
   
        header("Location: index.php");
        exit();
    } else {
     
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);

    header("Location: index.php?registration_success=true");

    mysqli_close($conn);
}
?>
