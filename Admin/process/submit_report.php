<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

try {
    // Debugging: Log all POST data
    error_log('POST Data: ' . print_r($_POST, true));
    error_log('Session Data: ' . print_r($_SESSION, true));

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Not logged in');
    }

    // Get user ID from session
    $account_ID = $_SESSION['user_id'];

    // Validate report message
    if (empty($_POST['reportMessage'])) {
        throw new Exception('Report message cannot be empty');
    }

    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO reports (account_ID, reportMessage, dateTime) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $account_ID, $reportMessage);

    $reportMessage = trim($_POST['reportMessage']);

    $result = $stmt->execute();
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Database insertion failed: ' . $stmt->error);
    }
} catch (Exception $e) {
    error_log('Report Submission Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage(),
        'error_details' => $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();