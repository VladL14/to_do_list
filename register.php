<?php
session_start();

include("db.php");

header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['uname'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $telephone = $_POST['tel'];
    $role = isset($_POST['request_admin']) ? 'admin' : 'user';

    if (!empty($email) && !empty($password) && !empty($telephone) && !empty($user_name) && !is_numeric($email) && is_numeric($telephone)) {

        $query = "INSERT INTO users (USERNAME, EMAIL, PASSWORD, PHONE_NUMBER, ROLE) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $user_name, $email, $password, $telephone, $role);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Success');</script>"; 
                echo "<script>window.location.href = 'login.html';</script>";
            } else {
                echo "<script>alert('Failed to register user');</script>"; 
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "<script>alert('Failed to prepare statement');</script>"; 
        }
    } else {
        echo "<script>alert('Please enter valid information');</script>"; 
    }
}
?>
