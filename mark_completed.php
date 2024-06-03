<?php
include("db.php");

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $query = "UPDATE tasks SET status = 'completed' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $task_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Task marked as completed');</script>";
        } else {
            echo "<script>alert('Failed to mark task as completed');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Failed to prepare statement');</script>";
    }
}
echo "<script>window.location.href = 'homepage.php';</script>";
?>
