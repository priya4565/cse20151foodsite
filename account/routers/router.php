<?php
session_start();

$servername = "cse20151db.mysql.database.azure.com";
$server_user = "cse20151root";
$server_pass = "abc_1234";
$dbname = "cse20151db";

$con = new mysqli($servername, $server_user, $server_pass, $dbname);

$success = false;

$username = $_POST['username'];
$password = $_POST['password'];

$result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Administrator' AND not deleted;");
while ($row = mysqli_fetch_array($result)) {
    $success = true;
    $user_id = $row['id'];
    $_SESSION['name'] = $row['name']; // Set session variables directly here
    $_SESSION['role'] = $row['role']; // Set session variables directly here
}

if ($success == true) {
    $_SESSION['admin_sid'] = session_id();
    $_SESSION['user_id'] = $user_id;
    header("location: ../admin-page.php");
} else {
    $result = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='Customer' AND not deleted;");
    while ($row = mysqli_fetch_array($result)) {
        $success = true;
        $user_id = $row['id'];
        $_SESSION['name'] = $row['name']; // Set session variables directly here
        $_SESSION['role'] = $row['role']; // Set session variables directly here
    }
    if ($success == true) {
        $_SESSION['customer_sid'] = session_id();
        $_SESSION['user_id'] = $user_id;
        header("location: ../index.php");
    } else {
        header("location: ../login.php");
    }
}
?>
