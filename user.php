<?php
session_start();
require 'connection.php';

// If logout is requested
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: homepage.php"); // redirect to homepage
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name    = $_SESSION['name'];

// Determine roles
$isAdmin = false;
$isStudent = false;

$adminCheck = mysqli_query($connection, "SELECT * FROM admin WHERE user_id = '$user_id'");
if (mysqli_num_rows($adminCheck) > 0) {
    $isAdmin = true;
}

$studentCheck = mysqli_query($connection, "SELECT * FROM student WHERE user_id = '$user_id'");
if (mysqli_num_rows($studentCheck) > 0) {
    $isStudent = true;
}

// Prepare options
$options = [];
if ($isStudent) {
    $options[] = "Messages";
    $options[] = "Notifications";
    $options[] = "Event Registration";
    $options[] = "Lost and Found";
}
if ($isAdmin) {
    $options[] = "Create Event";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $name; ?>!</h2>
    <h3>Your options:</h3>
    <ul>
        <?php
        foreach ($options as $option) {
            echo "<li>$option</li>";
        }
        ?>
    </ul>
    <br>
    <!-- Logout link triggers the same page with ?logout=true -->
    <a href="user.php?logout=true">Logout</a>
</body>
</html>
