<?php
    require_once '../Admin/config/database.php';

    $quizdata = array();

    //if (isset($_GET['section_id'])){
        $id = urldecode($_GET['section_id']);

        $stmt = $conn->prepare("SELECT DISTINCT activity.* FROM content 
            INNER JOIN activity ON content.activity_ID = activity.activityID
            WHERE section_ID = 1");
        //$stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0){
            while ($row = $result->fetch_assoc()){
                $quizdata[] = $row;
            }
        }

    echo json_encode($quizdata);
    //}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complite - Activity</title>
    <link rel="stylesheet" href="/CSS/inActivity.css">
</head>
<body>
  <header class="header-bottom">
    <div class="container">
        <a href="#" class="logo">COMPLITE</a>
        <nav class="navbar">
            <a href="/HTML/main.html" class="nav-link">Home</a>
            <a href="/HTML/Lessons.html" class="nav-link">Lessons</a>
            <a href="/HTML/Activity.html" class="nav-link">Activities</a>
            <a href="#" class="nav-link">About</a>
            <a href="#" class="nav-link">Profile</a>
        </nav>
    </div>
</header>

    <main>
        <section class="activity">
            <div class="progress-container">
                <div id="progressBar" class="progress-bar"></div>
            </div>
            <h1>Activity</h1>
            <div class="question-area">
                <p id="question"></p>
            </div>
            <div class="activity-content">
                <div class="activity-image">
                    <img id="activityImage" src="/path/to/activity-image.jpg" alt="Activity Image">
                </div>
                <div class="activity-controls">
                    <button id="btn1">Button 1</button>
                    <button id="btn2">Button 2</button>
                    <button id="btn3">Button 3</button>
                    <button id="btn4">Button 4</button>
                </div>
            </div>
            <div id="feedbackArea" class="feedback-area"></div>
            <div class="activity-navigation">
                <button id="previousBtn" class="previous">Previous</button>
                <button id="nextBtn" class="next">Next</button>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 COMPLITE. All rights reserved.</p>
    </footer>

    <!-- <script src="/JS/inActivity.js"></script> -->
    <!--  Not Working -->
    <script>
        const quizData = <?php echo json_encode($quizdata) ;?>;

        const activityImage = document.getElementById('activityImage');
        const questionText = document.getElementById('question');
        const buttons = [
            document.getElementById('btn1'),
            document.getElementById('btn2'),
            document.getElementById('btn3'),
            document.getElementById('btn4')
        ];
        const nextBtn = document.getElementById('nextBtn');
        const progressBar = document.getElementById('progressBar');
        const feedbackArea = document.getElementById('feedbackArea');

        // Current activity index
        let currentActivityIndex = -1;
        let selectedAnswer = null;
        let userAnswers = []; // Array to store user answers
        let startTime = new Date(); // Start time for the activity

        // Function to update activity
        function updateActivity(index) {
            const activity = quizdata[index];
            
            // Reset previous state
            resetButtonStyles();
            selectedAnswer = null;
            feedbackArea.textContent = '';
            feedbackArea.classList.remove('correct', 'incorrect');
            
            // Update image
            activityImage.src = quizdata.activityPicture;
            
            // Update question
            questionText.textContent = quizdata.activityQuestion;
            
            // Update buttons
            buttons.forEach((btn, i) => {
                btn.textContent = quizdata.activityChoices[i];
                btn.disabled = userAnswers[index] !== undefined; // Disable buttons if an answer was already selected for this question
                btn.addEventListener('click', () => checkAnswer(i));
            });
            
            // Update progress bar
            updateProgressBar();
            
            // Manage navigation buttons
            nextBtn.textContent = index === quizdata.length - 1 ? 'Done' : 'Next'; // Change text on the last question
            nextBtn.disabled = selectedAnswer === null; // Disable Next until an answer is selected
        }

        // Function to check answer
        function checkAnswer(selectedIndex) {
            const currentActivity = quizdata[currentActivityIndex];
            
            // Store the selected answer for this activity
            userAnswers[currentActivityIndex] = selectedIndex;
            
            // Reset button styles
            resetButtonStyles();
            
            // Mark selected button
            buttons[selectedIndex].classList.add(
                selectedIndex === currentActivity.correctAnswer ? 'correct' : 'incorrect'
            );
            
            // Update feedback
            if (selectedIndex === currentActivity.correctAnswer) {
                feedbackArea.textContent = 'Correct!';
                feedbackArea.classList.add('correct');
            } else {
                feedbackArea.textContent = 'Incorrect. Try again!';
                feedbackArea.classList.add('incorrect');
            }
            
            // Disable all buttons after an answer is selected
            buttons.forEach(btn => btn.disabled = true);
            
            selectedAnswer = selectedIndex;
            nextBtn.disabled = false; // Enable next button after answering
        }

        // Function to reset button styles
        function resetButtonStyles() {
            buttons.forEach(btn => {
                btn.classList.remove('correct', 'incorrect');
            });
        }

        // Function to update progress bar
        function updateProgressBar() {
            const progress = ((currentActivityIndex + 1) / quizdata.length) * 100;
            progressBar.style.width = `${progress}%`;
        }

        // Next button event listener
        nextBtn.addEventListener('click', () => {
            if (currentActivityIndex < quizdata.length - 1) {
                currentActivityIndex++;
                updateActivity(currentActivityIndex);
            } else {
                // Calculate score and time taken
                const endTime = new Date();
                const timeTaken = Math.round((endTime - startTime) / 1000); // Time in seconds
                const score = userAnswers.filter((answer, index) => answer === activities[index].activityKey).length;
                
                // Show results
                //alert(`Activity Complete! Your score: ${score}/${activities.length}\nTime Taken: ${timeTaken} seconds`);
                
                // Optionally, redirect to a ranking or results page (uncomment the line below for redirection)
                window.location.href = '/HTML/Lessons.html';
            }
        });

        // Initial activity load
        updateActivity(currentActivityIndex);
    </script>
</body>
</html>