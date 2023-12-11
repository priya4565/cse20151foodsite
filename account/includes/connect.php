<?php
session_start();
$servername = "cse20151db.mysql.database.azure.com";
$server_user = "cse20151root";
$server_pass = "abc_1234";
$dbname = "cse20151db";
$name = $_SESSION['name'];
$role = $_SESSION['role'];

// Create connection
$con = new mysqli($servername, $server_user, $server_pass, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>
