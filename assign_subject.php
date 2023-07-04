<?php
session_start();
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'teacher')) {
    header("Location: index.php");
    exit();
}
$role = $_SESSION['role'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    include 'db.php';

    $standardId = $_POST['standard'];
    $subjectIds = $_POST['subjects'];

    foreach ($subjectIds as $subjectId) {
        $query = "INSERT INTO standard_subject (standard_id, subject_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $standardId, $subjectId);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
}


include 'db.php';

$standardQuery = "SELECT * FROM standards";
$standardResult = mysqli_query($conn, $standardQuery);

$subjectQuery = "SELECT * FROM subjects";
$subjectResult = mysqli_query($conn, $subjectQuery);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Subjects to Standards</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        select {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
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
    <h1>Assign Subjects to Standards</h1>
    <form method="POST" action="">
        <label>Standard:</label><br>
        <select name="standard" required>
            <option value="">Select a standard</option>
            <?php while ($standard = mysqli_fetch_assoc($standardResult)) { ?>
                <option value="<?php echo $standard['id']; ?>"><?php echo $standard['standard']; ?></option>
            <?php } ?>
        </select><br><br>

        <label>Subjects:</label><br>
        <select name="subjects[]" multiple required>
            <?php while ($subject = mysqli_fetch_assoc($subjectResult)) { ?>
                <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject']; ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Assign">
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
