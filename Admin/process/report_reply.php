<?php
session_start();
require_once '../Admin/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportID = $_POST['reportID'];
    $replyMessage = $_POST['replyMessage'];
    $adminID = $_SESSION['adminID']; // Assuming you have admin ID in session
    $dateTime = date('Y-m-d H:i:s');

    // Insert reply into database
    $stmt = $conn->prepare("INSERT INTO report_replies (reportID, adminID, replyMessage, dateTime) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $reportID, $adminID, $replyMessage, $dateTime);

    if ($stmt->execute()) {
        // Update report status
        $updateStmt = $conn->prepare("UPDATE reports SET status = 'Replied' WHERE reportID = ?");
        $updateStmt->bind_param("i", $reportID);
        $updateStmt->execute();
        
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>