<?php
session_start(); // ADD THIS AT THE VERY TOP
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id  = $_POST['user_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
           
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name']    = $row['name'];

            
            header("Location: user.php");
            exit(); 
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that ID.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        User ID: <input type="text" name="user_id" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
