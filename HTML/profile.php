<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - COMPLITE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Oxanium:wght@800&display=swap" rel="stylesheet">
    <link href="../CSS/profile.css" rel="stylesheet">
</head>
<body>
    
    <header class="header">
        <div class="header-bottom">
            <div class="container">
                <a href="#" class="logo-container">
                    <img src="/Resources/Logo.png" alt="COMPLITE Robot Mascot" class="logo-image">
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

    <div class="profile-container">
        <div class="profile-picture">
            <img src="/path/to/profile-picture.jpg" alt="Profile Picture">
            <label for="upload-picture" class="upload-label">Change Picture</label>
            <input type="file" id="upload-picture" accept="image/*">
        </div>
        <div class="profile-details">
            <h1><?php 
                if (isset($_SESSION['firstname'])) {
                    echo $_SESSION['firstname'].' '. $_SESSION['lastname']; 
                } else {
                    echo "Guest";
                }
            ?></h1>
            <div class="detail-grid">
                <div class="profile-detail">
                    <span class="detail-label">Username</span>
                    <span class="detail-value" id="username"><?php echo $_SESSION['username']; ?></span>
                </div>
                <div class="profile-detail">
                    <span class="detail-label">Full Name</span>
                    <span class="detail-value" id="full-name"><?php echo $_SESSION['firstname'].' '. $_SESSION['middlename'].' '. $_SESSION['lastname']; ?></span>
                </div>
                <div class="profile-detail">
                    <span class="detail-label">Email</span>
                    <span class="detail-value" id="email"><?php echo $_SESSION['e']; ?></span>
                </div>
                <div class="profile-detail">
                    <span class="detail-label">Sex</span>
                    <span class="detail-value" id="sex"><?php echo $_SESSION['s']; ?></span>
                </div>
                <div class="profile-detail">
                    <span class="detail-label">Birth Date</span>
                    <span class="detail-value" id="birth-date"><?php echo $_SESSION['b']; ?></span>
                </div>
                <div class="profile-detail">
                    <span class="detail-label">Points</span>
                    <span class="detail-value" id="birth-date"><?php echo $_SESSION['p']; ?></span>
                </div>
            </div>
            <button class="edit-button">Edit Profile</button>
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
                        <a href="#" class="footer-link">Home</a>
                        <a href="/HTML/Lessons.html" class="footer-link">Lessons</a>
                        <a href="/HTML/Activity.html" class="footer-link">Activities</a>
                        <a href="#" class="footer-link">About</a>
                        <a href="#" class="footer-link">Profile</a>
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

    <script>
        document.querySelector('.edit-button').addEventListener('click', () => {
            // Future edit functionality
            alert('Edit profile feature coming soon!');
        });
    </script>
</body>
</html>