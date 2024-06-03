<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: homepage.php');
    exit();
}

include("db.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $task_id = $_GET['id'];

    $query = "SELECT * FROM tasks WHERE id = $task_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $task = mysqli_fetch_assoc($result);
    } else {
        echo "Task not found";
        exit();
    }
} else {
    echo "Invalid task ID";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = $_POST['nume'];
    $dificultate = $_POST['dificultate'];
    $descriere = $_POST['descriere'];
    $deadline = $_POST['deadline'];

    if (!empty($nume) && !empty($dificultate) && !empty($descriere) && !empty($deadline)) {
        $query = "UPDATE tasks SET nume=?, dificultate=?, descriere=?, deadline=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sissi", $nume, $dificultate, $descriere, $deadline, $task_id);

            if (mysqli_stmt_execute($stmt)) {
                header('Location: homepage.php');
                echo "<script>alert('Success');</script>";
            } else {
                echo "Failed to update task";
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
    <title>Edit Task</title>
</head>
<body>
    <div id="half1">
    <div id="glass2">
    <div id='inner'>
    <h1 id="h1">Edit Task</h1>
    <form method="post">
        <label for="nume" id="whitep4">Name:</label>
        <input type="text" name="nume"  value="<?php echo($task['nume']); ?>" id='ps1' required><br>
        <br>
        <label for="dificultate" id="whitep4">Difficulty (1-3):</label>
        <input type="number" name="dificultate"  value="<?php echo $task['dificultate']; ?>" min="1" max="3" id='ps1' required><br>
        <br>
        <label for="descriere" id="whitep4">Description:</label>
        <textarea name="descriere"  id='ps1' required><?php echo($task['descriere']); ?></textarea><br>
        <br>
        <label for="deadline" id="whitep4">Deadline:</label>
        <input type="date" name="deadline"  value="<?php echo $task['deadline']; ?>" id='ps1' required><br>
        <br>
        <input type="submit" value="Update Task" id='btn'>
    </form>
    <a href="homepage.php" id="register">Back to task list</a>
</div>
</div>
</div>
</body>
</html>
