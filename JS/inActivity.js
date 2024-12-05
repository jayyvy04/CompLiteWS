// Activity data
const activities = [
    {
        question: "What is the capital of France?",
        image: 'https://via.placeholder.com/500x300?text=Activity+1',
        buttons: ['London', 'Berlin', 'Paris', 'Madrid'],
        correctAnswer: 2
    },
    {
        question: "Which planet is known as the Red Planet?",
        image: 'https://via.placeholder.com/500x300?text=Activity+2',
        buttons: ['Venus', 'Mars', 'Jupiter', 'Saturn'],
        correctAnswer: 1
    },
    {
        question: "What is the largest mammal in the world?",
        image: 'https://via.placeholder.com/500x300?text=Activity+3',
        buttons: ['Elephant', 'Blue Whale', 'Giraffe', 'Hippopotamus'],
        correctAnswer: 1
    }
];

// DOM Elements
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
let currentActivityIndex = 0;
let selectedAnswer = null;
let userAnswers = []; // Array to store user answers
let startTime = new Date(); // Start time for the activity

// Function to update activity
function updateActivity(index) {
    const activity = activities[index];
    
    // Reset previous state
    resetButtonStyles();
    selectedAnswer = null;
    feedbackArea.textContent = '';
    feedbackArea.classList.remove('correct', 'incorrect');
    
    // Update image
    activityImage.src = activity.image;
    
    // Update question
    questionText.textContent = activity.question;
    
    // Update buttons
    buttons.forEach((btn, i) => {
        btn.textContent = activity.buttons[i];
        btn.disabled = userAnswers[index] !== undefined; // Disable buttons if an answer was already selected for this question
        btn.addEventListener('click', () => checkAnswer(i));
    });
    
    // Update progress bar
    updateProgressBar();
    
    // Manage navigation buttons
    nextBtn.textContent = index === activities.length - 1 ? 'Done' : 'Next'; // Change text on the last question
    nextBtn.disabled = selectedAnswer === null; // Disable Next until an answer is selected
}

// Function to check answer
function checkAnswer(selectedIndex) {
    const currentActivity = activities[currentActivityIndex];
    
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
    const progress = ((currentActivityIndex + 1) / activities.length) * 100;
    progressBar.style.width = `${progress}%`;
}

// Next button event listener
nextBtn.addEventListener('click', () => {
    if (currentActivityIndex < activities.length - 1) {
        currentActivityIndex++;
        updateActivity(currentActivityIndex);
    } else {
        // Calculate score and time taken
        const endTime = new Date();
        const timeTaken = Math.round((endTime - startTime) / 1000); // Time in seconds
        const score = userAnswers.filter((answer, index) => answer === activities[index].correctAnswer).length;
        
        // Show results
        //alert(`Activity Complete! Your score: ${score}/${activities.length}\nTime Taken: ${timeTaken} seconds`);
        
        // Optionally, redirect to a ranking or results page (uncomment the line below for redirection)
        window.location.href = '/HTML/Lessons.html';
    }
});

// Initial activity load
updateActivity(currentActivityIndex);
