<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: homepage.php');
    exit();
}

include("db.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    $query = "DELETE FROM tasks WHERE id = $task_id";
    if (mysqli_query($conn, $query)) {
        header('Location: homepage.php');
        echo "<script>alert('Success');</script>";
    } else {
        echo "Failed to delete task";
    }
} else {
    echo "Invalid task ID";
}
?>
