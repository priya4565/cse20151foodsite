<?php
session_start();

$servername = "cse20151db.mysql.database.azure.com";
$server_user = "cse20151root";
$server_pass = "abc_1234";
$dbname = "cse20151db";

$con = new mysqli($servername, $server_user, $server_pass, $dbname);

$username = $_POST['username'];
$password = $_POST['password'];

// Azure Function URL
$azureFunctionUrl = 'https://cse20151fn.azurewebsites.net/api/HttpTrigger1?code=edTGGwacUUCbyt7ENuKvHq3LzW9jgq1lWavGiW63J2gPAzFumQFKpQ=='; // Replace with your actual Azure Function URL

// Data to send to Azure Function
$data = [
    'action' => 'login',
    'username' => $username,
    'password' => $password
];

// Initialize cURL session
$ch = curl_init($azureFunctionUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);

// Execute cURL session and get the response
$response = curl_exec($ch);

// Check for cURL errors
if ($response === false) {
    $error = curl_error($ch);
    echo 'cURL Error: ' . $error;
} else {
    // Handle the response from Azure Function
    $responseData = json_decode($response, true);
    if ($responseData && isset($responseData['status']) && $responseData['status'] === 200) {
        // Login successful, handle accordingly
        $userData = json_decode($responseData['body'], true);
        $role = $userData['role']; // Assuming role is present in the Azure Function response
        $_SESSION['name'] = $userData['username']; // Set session variables
        $_SESSION['role'] = $role; // Set session variables

        if ($role === 'Administrator') {
            $_SESSION['admin_sid'] = session_id();
            header("location: ../admin-page.php");
        } else if ($role === 'Customer') {
            $_SESSION['customer_sid'] = session_id();
            header("location: ../index.php");
        } else {
            // Handle other roles or scenarios as needed
        }
    } else {
        // Login failed, handle accordingly
        echo 'Login failed: ' . $responseData['body'];
        header("location: ../login.php");
    }
}

// Close cURL session
curl_close($ch);
?>
