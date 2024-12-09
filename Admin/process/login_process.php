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

            switch ($user['accountType']){
                case 'Student':
                    $sql1 = $conn->prepare("SELECT * FROM student_profile WHERE account_ID = ?");
                    $sql1->bind_param("i", $_SESSION['user_id']);
                    $sql1->execute();
                    $result = $sql1->get_result();

                    if ($result->num_rows === 1) {
                        $student = $result->fetch_assoc();
                        $_SESSION['student_id'] = $student['studentID'];
                        $_SESSION['firstname'] = $student['firstName'];
                        $_SESSION['lastname'] = $student['lastName'];
                        $_SESSION['middlename'] = $student['middleName'];
                        $_SESSION['s'] = $student['sex'];
                        $_SESSION['b'] = $student['birthDate'];
                        $_SESSION['e'] = $student['email'];
                        $_SESSION['p'] = $student['points'];
                    }
                    break;
                case 'Instructor':
                    $sql2 = $conn->prepare("SELECT * FROM instructor_profile WHERE account_ID = ?");
                    $sql2->bind_param("i", $_SESSION['user_id']);
                    $sql2->execute();
                    $result = $sql2->get_result();

                    if ($result->num_rows === 1) {
                        $instructor = $result->fetch_assoc();
                        $_SESSION['instructor_id'] = $instructor['instructorID'];
                        $_SESSION['firstname'] = $instructor['firstName'];
                        $_SESSION['lastname'] = $instructor['lastName'];
                        $_SESSION['middlename'] = $instructor['middleName'];
                        $_SESSION['s'] = $instructor['sex'];
                        $_SESSION['b'] = $instructor['birthDate'];
                        $_SESSION['e'] = $instructor['email'];
                        $_SESSION['p'] = $instructor['points'];
                    }
                    break;
                case 'Admin':
                    $sql3 = $conn->prepare("SELECT * FROM admin WHERE account_ID = ?");
                    $sql3->bind_param("i", $_SESSION['user_id']);
                    $sql3->execute();
                    $result = $sql3->get_result();

                    if ($result->num_rows === 1) {
                        $admin = $result->fetch_assoc();
                        $_SESSION['admin_id'] = $admin['adminID'];
                        $_SESSION['firstname'] = $admin['firstName'];
                        $_SESSION['lastname'] = $admin['lastName'];
                        $_SESSION['middlename'] = $admin['middleName'];
                        $_SESSION['s'] = $admin['sex'];
                        $_SESSION['b'] = $admin['birthDate'];
                        $_SESSION['e'] = $admin['email'];
                        $_SESSION['p'] = $admin['points'];
                    }
                    break;
                default:
                    break;
            }

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