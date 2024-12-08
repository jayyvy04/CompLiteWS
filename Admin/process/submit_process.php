<?php
// File: C:\wamp64\www\CompLiteWS-1\process\submit_report.php
require_once '../Admin/config/database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (!isset($data['accountID']) || !isset($data['reportMessage'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    $accountID = $conn->real_escape_string($data['accountID']);
    $reportMessage = $conn->real_escape_string($data['reportMessage']);

    // Prepare and execute SQL
    $sql = "INSERT INTO reports (account_ID, reportMessage) VALUES ('$accountID', '$reportMessage')";
    
    if ($conn->query($sql)) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Report submitted successfully',
            'reportID' => $conn->insert_id
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error', 
            'message' => 'Failed to submit report: ' . $conn->error
        ]);
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
}
?>