<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: homepage.php');
    exit();
}

include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = $_POST['nume'];
    $dificultate = $_POST['dificultate'];
    $descriere = $_POST['descriere'];
    $deadline = $_POST['deadline'];

    if (!empty($nume) && !empty($dificultate) && !empty($descriere) && !empty($deadline)) {
        $query = "INSERT INTO tasks (nume, dificultate, descriere, deadline) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "siss", $nume, $dificultate, $descriere, $deadline);

            if (mysqli_stmt_execute($stmt)) {
                
                header('Location: homepage.php');
                echo "<script>alert('Success');</script>";
            } else {
                echo "Failed to add task";
            }

            mysqli_stmt_close($stmt);
        }
    } else {
        echo "Please fill all fields";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit.css">
    <title>Add Task</title>
</head>
<body>
<div id="half1">
    <div id="glass2">
    <div id='inner'>
    <h1 id="h1">Add Task</h1>
    <form method="post">
        <label for="nume" id="whitep4">Name:</label>
        <input type="text" name="nume"  required id='ps1'><br>
        <br>
        <label for="dificultate" id="whitep4">Difficulty (1-3):</label>
        <input type="number" name="dificultate"  min="1" max="3" required  id='ps1'><br>
        <br>
        <label for="descriere" id="whitep4">Description:</label>
        <textarea name="descriere"  required id='ps1'></textarea><br>
        <br>
        <label for="deadline" id="whitep4">Deadline:</label>
        <input type="date" name="deadline" id="ps1" required><br>
        <br>
        <input type="submit" value="Add Task" id='btn'>
    </form>
    <a href="homepage.php" id="register">Back to task list</a>
    </div>
</div>
</div>
</body>
</html>
