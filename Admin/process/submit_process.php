<?php
session_start();
require_once '../Admin/config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_ID = $_POST['account_ID'];
    $reportMessage = $_POST['reportMessage'];

    // Validate input
    if (!empty($reportMessage)) {
        $stmt = $conn->prepare("INSERT INTO reports (account_ID, reportMessage) VALUES (?, ?)");
        $stmt->bind_param("is", $account_ID, $reportMessage);
        
        if ($stmt->execute()) {
            // Redirect back with success message
            $_SESSION['report_success'] = "Report submitted successfully!";
            header("Location: ../HTML/main.php");
            exit();
        } else {
            // Handle error
            $_SESSION['report_error'] = "Failed to submit report. Please try again.";
            header("Location: ../HTML/main.php");
            exit();
        }
    }
}