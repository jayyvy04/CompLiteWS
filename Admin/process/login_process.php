<?php
session_start();
$config_path = realpath(__DIR__ . '/../config/database.php');
if ($config_path === false) {
    die('Could not find database config file. Path: ' . __DIR__ . '/../config/database.php');
}
require_once($config_path);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("SELECT accountID, username, password, accountType FROM accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['accountID'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['account_type'] = $user['accountType'];

            // Redirect based on account type
            header("Location: ../dashboard.php");
            exit();
        }
    }

    // If login fails
    header("Location: ../../index.html?error=1");
    exit();
}
?>