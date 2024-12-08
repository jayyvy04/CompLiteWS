<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

// Route to appropriate dashboard based on account type
switch ($_SESSION['account_type']) {
    case 'Admin':
        header("Location: ../HTML/Admin_Dashboard.html");
        break;
    case 'Instructor':
        // Create instructor dashboard when ready
        header("Location: ../HTML/instructor-main.html");
        break;
    case 'Student':
        // Create student dashboard when ready
        header("Location: ../HTML/main.html");
        break;
    default:
        session_destroy();
        header("Location: ../index.html");
        break;
}
exit();
?>