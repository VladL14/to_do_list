<?php
session_start();

include("db.php");

header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['psw'])) {
        $email = $_POST['email'];
        $password = $_POST['psw'];

        if (!empty($email) && !empty($password) && !is_numeric($email)) {
            $query = "SELECT * FROM users WHERE EMAIL = '$email'";
            
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['password'] == $password) {
                    $_SESSION['user_id'] = $user_data['id'];
                    $_SESSION['user_name'] = $user_data['username'];
                    $_SESSION['role'] = $user_data['role'];
                    echo "<script>alert('Success');</script>";
                    echo "<script>window.location.href = 'homepage.php';</script>";
                } else {
                    echo "<script>alert('Incorrect password');</script>"; 
                }
            } else {
                echo "<script>alert('User not found');</script>"; 
            }
        }
    } else {
        echo "<script>alert('Please enter valid information');</script>";
    }
}
?>
