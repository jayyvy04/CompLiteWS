<?php
$config_path = realpath(__DIR__ . '/../config/database.php');
if ($config_path === false) {
    die('Could not find database config file. Path: ' . __DIR__ . '/../config/database.php');
}
require_once($config_path);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $middleName = $_POST['middleName'];
    $birthDate = $_POST['birthDate'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $accountType = $_POST['accountType'];

    // Check if username already exists
    $checkStmt = $conn->prepare("SELECT username FROM accounts WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Username already exists!'
        ]);
        exit();
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into accounts table
        $accountSql = "INSERT INTO accounts (username, password, accountType, status) VALUES (?, ?, ?, 'Active')";
        $accountStmt = $conn->prepare($accountSql);
        $accountStmt->bind_param("sss", $username, $password, $accountType);
        $accountStmt->execute();
        $account_id = $conn->insert_id;

        // Insert into the appropriate profile table based on account type
        switch ($accountType) {
            case 'Admin':
                $profileSql = "INSERT INTO admin (account_ID, firstName, lastName, middleName, email, sex, birthDate) VALUES (?, ?, ?, ?, ?, ?, ?)";
                break;
            case 'Instructor':
                $profileSql = "INSERT INTO instructor_profile (account_ID, firstName, lastName, middleName, email, sex, birthDate) VALUES (?, ?, ?, ?, ?, ?, ?)";
                break;
            case 'Student':
                $profileSql = "INSERT INTO student_profile (account_ID, firstName, lastName, middleName, email, sex, birthDate, points, grades) VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0.0)";
                break;
        }

        $profileStmt = $conn->prepare($profileSql);
        $profileStmt->bind_param("issssss", $account_id, $firstName, $lastName, $middleName, $email, $sex, $birthDate);
        $profileStmt->execute();

        // Commit the transaction
        $conn->commit();

        echo json_encode([
            'status' => 'success', 
            'message' => 'Account created successfully!'
        ]);
    } catch (Exception $e) {
        // Rollback the transaction
        $conn->rollback();

        echo json_encode([
            'status' => 'error', 
            'message' => 'Error creating account: ' . $e->getMessage()
        ]);
    }

    $accountStmt->close();
    $profileStmt->close();
    $conn->close();
} else {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Invalid request method'
    ]);
}
?>
