<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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
    <main>
        <h1>Main Content</h1>
        <?php if ($role === 'admin') { ?>
            
        <?php } elseif ($role === 'teacher') { ?>
            
        <?php } elseif ($role === 'student') { ?>
           
        <?php } ?>
    </main>
</body>
</html>
