<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
$role = $_SESSION['role'];
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 
    $action = $_POST['action'];

   
    if ($action === 'add') {
        $standard = $_POST['standard'];

        $query = "INSERT INTO standards (standard) VALUES '$standard'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $standard);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
    } elseif ($action === 'delete') {
        $standardId = $_POST['standard_id'];

        $query = "DELETE FROM standards WHERE id = '$standardId'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $standardId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    } elseif ($action === 'edit') {
        $standardId = $_POST['standard_id'];
        $standard = $_POST['standard'];

        $query = "UPDATE standards SET standard = ' $standard'? WHERE id = '$standardId'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'si', $standard, $standardId);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .profile h3 {
            margin: 0;
        }
        
        .menu a {
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
        }
        
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .section th, .section td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        
        .section th {
            background-color: #f7f7f7;
        }
        
        .container h1 {
            margin-bottom: 10px;
        }
        
        .container form {
            margin-bottom: 20px;
        }
        
        .container label {
            font-weight: bold;
        }
        
        .container input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
        
        .container input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
        
        .container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
     <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h1>Welcome to the Dashboard</h1>
        <p><?php echo "Welcome" ." ".$_SESSION['username'] ." you are  ". "$role"; ?> | <a href="logout.php">Logout</a></p>
    </header>
    <nav>
        <ul>
            <?php if ($role === 'admin') { ?>
                <li><a href="add_subject.php">Subject</a></li>
                <li><a href="add_standard.php">Standard</a></li>
                <li><a href="add_chapter.php">Chapter</a></li>
                <li><a href="assign_chapter.php">Assign Chapters to Subjects</a></li>
                <li><a href="assign_subject.php">Assign Subjects to Standards</a></li>
                <li><a href="assign_students.php">Assign Students to Standards</a></li>
            <?php } elseif ($role === 'teacher') { ?>
                <li><a href="add_subject.php">Subject</a></li>
                <li><a href="add_chapter.php">Chapter</a></li>
                <li><a href="assign_subject.php">Assign Subjects to Standards</a></li>
                <li><a href="assign_students.php">Assign Students to Standards</a></li>
            <?php } elseif ($role === 'student') { ?>
                <li><a href="view_subjects.php">View Subjects</a></li>
                <li><a href="view_chapters.php">View Chapters</a></li>
                <li><a href="view_standards.php">View Standards</a></li>
            <?php } ?>
        </ul>
    </nav>
    <div class="container">
        <div class="header">
            <div class="profile">
                <h3>List All Standard</h3>
            </div>
            <div class="menu">
                <form action="" method="post">
                    <a href="dashboard.php">Back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
    
    <?php
    include "db.php";
    $query = "SELECT * FROM standards";
    $result1 = mysqli_query($conn, $query);
    if (mysqli_num_rows($result1) > 0) {
        ?>
        <div class="container">
            <div class="section">
                <table>
                    <thead>
                        <tr>        
                            <th>ID</th>
                            <th>Standard</th>
                            <th>Update Data</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <?php
                    while ($row = mysqli_fetch_assoc($result1)) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['standard']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="standard_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="text" name="standard" required>
                                    <input type="submit" value="Edit">
                                </form>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="standard_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="submit" value="Delete">
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='container'>No records found!</div>";
    }
    ?>
    <div class="container">
        <h1>Add standard</h1>
        <form method="POST" action="">
            <label>standard:</label><br>
            <input type="text" name="standard" required><br><br>
            <input type="hidden" name="action" value="add">
            <input type="submit" value="Add">
        </form>
    </div>
</body>
</html>
