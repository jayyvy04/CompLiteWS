<?php
    session_start();
    require_once '../Admin/config/database.php';

    $totalStudent = 0;
    $totalInstructor = 0;
    $totalAdmin = 0;

    $stmt = "SELECT COUNT(accountID) AS totalStudent from accounts WHERE accountType = 'Student'";
    $r1 = $conn->query($stmt);

    if ($r1->num_rows > 0) {
        // Output data of each row
        while($row1 = $r1->fetch_assoc()) {
            $totalStudent = $row1["totalStudent"];
        }
    } 

    $stmt2 = "SELECT COUNT(accountID) AS totalInstructor from accounts WHERE accountType = 'Instructor'";
    $r2 = $conn->query($stmt2);

    if ($r2->num_rows > 0) {
        // Output data of each row
        while($row2 = $r2->fetch_assoc()) {
            $totalInstructor = $row2["totalInstructor"];
        }
    } 

    $stmt3 = "SELECT COUNT(accountID) AS totalAdmin from accounts WHERE accountType = 'Admin'";
    $r3 = $conn->query($stmt3);

    if ($r3->num_rows > 0) {
        // Output data of each row
        while($row3 = $r3->fetch_assoc()) {
            $totalAdmin = $row3["totalAdmin"];
        }
    } 

    $stmt4 = "SELECT * FROM reports";
    $r4 = $conn->query($stmt4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../CSS/Admin.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <div class="sidebar-menu">
            <button class="sidebar-btn active" onclick="showSection('accountForm')">
                <i class="fas fa-user"></i> Account
            </button>
            <button class="sidebar-btn" onclick="showSection('reportsSection')">
                <i class="fas fa-chart-bar"></i> Reports</button>
            <button class="sidebar-btn" onclick="showSection('userOverview')">
                <i class="fas fa-users"></i> User Overview
            </button>
            <button class="sidebar-btn logout-btn" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>

    <div class="main-content">
        <form id="accountCreationForm" method="POST" action="/../process/create_account.php">
            <div class="dashboard-card" id="accountForm">
                <h3>Create Account</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="firstName" class="form-input" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="lastName" class="form-input" placeholder="Enter Last Name" required>
                    </div>
                    <div class="form-group">
                        <label>Middle Name</label>
                        <input type="text" name="middleName" class="form-input" placeholder="Enter Middle Name">
                    </div>
                    <div class="form-group">
                        <label>Birthdate</label>
                        <input type="date" name="birthDate" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label>Sex</label>
                        <select name="sex" class="form-input" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-input" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-input" placeholder="Enter Username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-input" placeholder="Enter Password" required>
                    </div>
                    <div class="form-group">
                        <label>Account Type</label>
                        <select name="accountType" class="form-input" required>
                            <option value="Admin">Admin</option>
                            <option value="Instructor">Instructor</option>
                            <option value="Student">Student</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="submit-btn" style="width: 100%; margin-top: 20px;">Create Account</button>
            </div>
        </form>

        <!-- Reports Section -->
        <div id="reportsSection" class="dashboard-card" style="display: none;">
            <h3>Reports</h3>
            <div class="table-container">
                <?php 
                    if ($r4->num_rows > 0){
                        while($rows4 = $r4->fetch_assoc()) {
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>From Account ID</th>
                            <th>Description</th>
                            <th>Time and Date</th>
                        </tr>
                        <tr>
                            <td><?php echo $rows4['reportID']; ?></td>
                            <td><?php echo $rows4['account_ID']; ?></td>
                            <td><?php echo $rows4['reportMessage']; ?></td>
                            <td><?php echo $rows4['dateTime']; ?></td>
                        <tr>
                <?php
                        }
                    }
                ?>
                    </thead>
                    <tbody>
                        <!-- Reports will be dynamically populated -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- User Overview -->
        <div id="userOverview" class="dashboard-card" style="display: none;">
            <h3>User Overview</h3>
            <div class="stat-grid">
                <div class="stat-card">
                    <h4>Total Students</h4>
                    <p id="totalStudents"><?php echo $totalStudent;?></p>
                </div>
                <div class="stat-card">
                    <h4>Total Instructors</h4>
                    <p id="totalInstructors"><?php echo $totalInstructor;?></p>
                </div>
                <div class="stat-card">
                    <h4>Total Admins</h4>
                    <p id="totalAdmins"><?php echo $totalAdmin;?></p>
                </div>
            </div>
        </div>
    </div>
    <script src="../JS/Logout.js"></script>
    <script src="../JS/Admin.js"></script>
</body>
</html>