<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
$role = $_SESSION['role'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    include 'db.php';

    $subjectId = $_POST['subject'];
    $chapterIds = $_POST['chapters'];

    foreach ($chapterIds as $chapterId) {
        $query = "INSERT INTO subject_chapter (subject_id, chapter_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $subjectId, $chapterId);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
}


include 'db.php';

$subjectQuery = "SELECT * FROM subjects";
$subjectResult = mysqli_query($conn, $subjectQuery);

$chapterQuery = "SELECT * FROM chapters";
$chapterResult = mysqli_query($conn, $chapterQuery);

mysqli_close($conn);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Assign Chapters to Subjects</title>
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
    <h1>Assign Chapters to Subjects</h1>
    <form method="POST" action="">
        <label>Subject:</label><br>
        <select name="subject" required>
            <option value="">Select a subject</option>
            <?php while ($subject = mysqli_fetch_assoc($subjectResult)) { ?>
                <option value="<?php echo $subject['id']; ?>"><?php echo $subject['subject']; ?></option>
            <?php } ?>
        </select><br><br>

        <label>Chapters:</label><br>
        <select name="chapters[]" multiple required>
            <?php while ($chapter = mysqli_fetch_assoc($chapterResult)) { ?>
                <option value="<?php echo $chapter['id']; ?>"><?php echo $chapter['chapter']; ?></option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Assign">
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
