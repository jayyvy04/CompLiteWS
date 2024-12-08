<?php
session_start();

// Include database connection
require_once '../config/database.php';

// Check if user is an admin (adjust based on your authentication system)
//if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'Admin') {
 //   die(json_encode(['error' => 'Unauthorized access']));
//}

// Fetch reports
$query = "SELECT reportID, account_ID, reportMessage, dateTime FROM reports ORDER BY dateTime DESC";
$result = $conn->query($query);

$reports = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reports[] = $row;
    }
}

echo json_encode($reports);

$conn->close();
?>