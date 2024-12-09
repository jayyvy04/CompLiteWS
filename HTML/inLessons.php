<?php
    require_once '../Admin/config/database.php';

    if (isset($_GET['section_id'])){
        $id = urldecode($_GET['section_id']);

        $stmt = $conn->prepare("SELECT section.courseName, section.courseDescription, lesson.* FROM content 
            INNER JOIN section ON content.section_ID = section.sectionID
            INNER JOIN lesson ON content.lesson_ID = lesson.lessonID
            WHERE section_ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $content = array();
        $title = array();
        $description = array();
        $picture = array();

        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $content[] = $row['lessonContent'];
                $title[] = $row['courseName'];
                $description[] = $row['courseDescription'];
                $picture[] = $row['lessonPicture'];
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lessons - COMPLITE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Oxanium:wght@800&display=swap" rel="stylesheet">
    <link href="../CSS/InLessons.css" rel="stylesheet">
</head>
<body>
    <header class="header-bottom">
        <div class="container">
            <a href="#" class="logo">COMPLITE</a>
            <nav class="navbar">
                <a href="../HTML/main.html" class="nav-link">Home</a>
                <a href="../HTML/Lessons.html" class="nav-link">Lessons</a>
                <a href="../HTML/Activity.html" class="nav-link">Activities</a>
                <a href="#" class="nav-link">About</a>
                <a href="#" class="nav-link">Profile</a>
            </nav>
        </div>
    </header>

    <body>
        <section class="lesson">
            <h1>Lesson 1: <?php echo $title[0]; ?></h1>
            <div class="content">
                <p class="p1">
                    <strong>Objective:</strong><br>
                    <?php echo $description[0]; ?>
                </p>
                <h3><?php echo $content[0]?></h3>
                <p>
                    <?php echo $content[1]?>
                </p>
    
                <div class="content1">
                    <h3><?php echo $content[2]?></h3>
    
                    <!-- Input Devices Section -->
                    <div class="row">
                        <div class="lesson-text">
                            <h4><strong><?php echo $content[3]?></strong></h4>
                            <p>
                            <?php echo $content[4]?>
                            </p>
                            <ul>
                                <li><?php echo $content[4]?></li>
                                <li><?php echo $content[6]?></li>
                                <li><?php echo $content[7]?></li>
                            </ul>
                        </div>
                        <div class="lesson-image">
                            <img src="<?php echo "../Resources/{$picture[8]}" ?>" alt="Input Devices">
                        </div>
                    </div>

    
                <div class="btn-wrapper">
                    <button onclick="window.location.href='../HTML/inActivity.html'">Done</button>
                </div>
            </div>
        </section>
    </body>
    
    <footer>
        <p>&copy; 2024 COMPLITE. All rights reserved.</p>
    </footer>
    
    <script src="../JS/lessons.js"></script>

</html>

<?php
    }
?>