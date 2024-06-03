<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$query = "SELECT * FROM tasks";
$result = mysqli_query($conn, $query);
$tasks = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($task = mysqli_fetch_assoc($result)) {
        $tasks[] = $task;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homepage.css">
    <title>To Do List</title>
    <script>
        function markCompleted(taskId) {
            if (confirm("Are you sure you want to mark this task as completed?")) {
                window.location.href = "mark_completed.php?id=" + taskId;
            }
        }

        function deleteTask(taskId) {
            if (confirm("Are you sure you want to delete this task?")) {
                window.location.href = "delete_task.php?id=" + taskId;
            }
        }
    </script>
</head>
<body>
<nav id="nav">
    <h1 id="h1">To do list</h1>
    <p id="whitep2">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! You are logged in as <?php echo htmlspecialchars($_SESSION['role']); ?>.</p>

    <?php if ($_SESSION['role'] == 'admin'): ?>
    <div class="dropdown">
        <button class="dropbtn">Admin Actions</button>
        <div class="dropdown-content">
            <a href="add_task.php">Add Task</a>
            <a href="login.html">Logout</a>
        </div>
    </div>
    <?php else: ?>
    <a href="login.html" id="whitep5">Logout</a>
    <?php endif; ?>
</nav>
<table border="1">
    <tr>
        <th>Nume</th>
        <th>Dificultate</th>
        <th>Descriere</th>
        <th>Deadline</th>
        <th>Status</th>
        <?php if ($_SESSION['role'] == 'admin'): ?>
        <th>Actions</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($tasks as $task): ?>
    <tr>
        <td><?php echo ($task['nume']); ?></td>
        <td><?php echo ($task['dificultate']); ?></td>
        <td><?php echo ($task['descriere']); ?></td>
        <td><?php echo ($task['deadline']); ?></td>
        <td><?php echo ($task['status']); ?></td>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <td>
        <button class="dropbtn" onclick='markCompleted(<?php echo $task["id"]; ?>)'>Mark as Completed</button>
        <button class="dropbtn" onclick='deleteTask(<?php echo $task["id"]; ?>)'>Delete</button>
        </td>

        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
