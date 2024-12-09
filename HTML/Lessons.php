<?php
    session_start();
    require_once '../Admin/config/database.php';

    if (isset($_SESSION['student_id'])){
        $stmt = $conn->prepare("SELECT section.sectionID, section.courseName, section.courseDescription FROM enroll_section INNER JOIN section ON enroll_section.section_ID = section.sectionID WHERE student_ID = ?");
        $stmt->bind_param("i", $_SESSION['student_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        echo 'This';
    } else {
        echo 'That';
    }   
    $stmt = $conn->prepare("SELECT section.sectionID, section.courseName, section.courseDescription FROM enroll_section INNER JOIN section ON enroll_section.section_ID = section.sectionID WHERE student_ID = ?");
    $stmt->bind_param("i", $_SESSION['student_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    echo $_SESSION['student_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons - COMPLITE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Oxanium:wght@800&display=swap" rel="stylesheet">
    <link href="../CSS/Lessons.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="header-bottom">
            <div class="container">
                <a href="#" class="logo-container">
                    <img src="../Resources/Logo.png" alt="COMPLITE Robot Mascot" class="logo-image">
                    <span class="logo-text">COMPLITE</span>
                </a>
                <nav class="navbar">
                    <a href="../HTML/main.php" class="nav-link">Home</a>
                    <a href="../HTML/Lessons.php" class="nav-link">Lessons</a>
                    <a href="../HTML/Activity.html" class="nav-link">Activities</a>
                    <a href="../HTML/about.html" class="nav-link">About</a>
                    <a href="../HTML/profile.php" class="nav-link">Profile</a>
                    <a href="../Admin/process/logout.php" class="nav-link">Logout</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="main-content">
        <header class="page-header">
            <div class="content-header">
                <h1>Lessons</h1>
                <p>Explore our interactive learning materials</p>
            </div>
        </header>

        <?php
            if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()){
        ?>

        <div class="card-grid">
            <a href="../HTML/inLessons.php?section_id=<?php echo urlencode($row['sectionID']); ?>" class="lesson-card">
                <img src="../Resources/lesson1.jpg" alt="Lesson 1">
                <div class="lesson-card-content">
                    <h3><?php echo $row['courseName']; ?></h3>
                    <p><?php echo $row['courseDescription'];?></p>
                </div>
            </a>
        
        <?php
                }
            }
        ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="h3">About COMPLITE</h3>
                    <p class="about-text">Educational platform dedicated to interactive learning</p>
                </div>
                
                <div class="footer-section">
                    <h3 class="h3">Navigation</h3>
                    <nav class="footer-nav">
                        <a href="../HTML/main.php" class="footer-link">Home</a>
                        <a href="../HTML/Lessons.html" class="footer-link">Lessons</a>
                        <a href="../HTML/Activity.html" class="footer-link">Activities</a>
                        <a href="../HTML/About.html" class="footer-link">About</a>
                        <a href="../HTML/profile.html" class="footer-link">Profile</a>
                    </nav>
                </div>
                
                <div class="footer-section">
                    <h3 class="h3">Contact</h3>
                    <nav class="footer-nav">
                    <p>Email: contact@complite.com</p>
                    <p>Phone: (123) 456-7890</p>
                    <a href="#" class="footer-link"><h3>Send a Report?</h3></a>
                    </nav>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 COMPLITE. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="../JS/lesson.js"></script>
</body>
</html>