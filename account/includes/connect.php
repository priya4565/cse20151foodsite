<?php
session_start();
$servername = "cse20151db.mysql.database.azure.com";
$server_user = "cse20151root";
$server_pass = "abc_1234";
$dbname = "cse20151db";
$name = $_SESSION['name'];
$role = $_SESSION['role'];
$con = new mysqli($servername, $server_user, $server_pass, $dbname);
?>