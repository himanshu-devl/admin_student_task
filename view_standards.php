<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: index.php");
    exit();
}
$role = $_SESSION['role'];

include 'db.php';

$query = "SELECT * FROM standards";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Standards</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            max-width: 600px;
            margin: 0 auto;
        }

        li {
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
      <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Welcome to the Dashboard</h2>
        <p><?php echo "Welcome" ." ".$_SESSION['username'] ." you are  ". "$role"; ?> | <a href="logout.php">Logout</a></p>
    </header>
    <h1>View Standards</h1>
    <ul>
        <?php while ($standard = mysqli_fetch_assoc($result)) { ?>
            <li><?php echo $standard['standard']; ?></li>
        <?php } ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

