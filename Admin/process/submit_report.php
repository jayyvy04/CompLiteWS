<?php
session_start();

// Include database connection
require_once '../config/database.php';

// Check if user is logged in (you may want to adjust this logic based on your authentication system)
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $reportMessage = isset($_POST['reportMessage']) ? trim($_POST['reportMessage']) : '';
    $userId = $_SESSION['user_id']; // Assuming you store user ID in session

    // Validate report message
    if (empty($reportMessage)) {
        die(json_encode(['success' => false, 'message' => 'Report message cannot be empty']));
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO reports (account_ID, reportMessage) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $reportMessage);

    // Execute the statement and send response
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Report submitted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit report: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>