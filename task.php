<?php
session_start();

include("db.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    $query = "SELECT * FROM tasks WHERE id = $task_id";
    $result = mysqli_query($conn, $query);

    // Check if the task was found
    if ($result && mysqli_num_rows($result) > 0) {
        $task = mysqli_fetch_assoc($result);
    } else {
        echo "Task not found";
        exit;
    }
} else {
    echo "Invalid task ID";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($task['nume']); ?></h1>
    <p><strong>Dificultate:</strong> <?php echo $task['dificultate']; ?></p>
    <p><strong>Descriere:</strong> <?php echo nl2br(htmlspecialchars($task['descriere'])); ?></p>
    <p><strong>Deadline:</strong> <?php echo $task['deadline']; ?></p>
    <a href="homepage.php">Back to task list</a>
</body>
</html>
