document.addEventListener('DOMContentLoaded', () => {
    // Function to update results dynamically
    function updateResults(data) {
        document.getElementById('totalPoints').textContent = data.totalPoints;
        document.getElementById('timeTaken').textContent = `${data.timeTaken} mins`;
        document.getElementById('accuracy').textContent = `${data.accuracy}%`;
        document.getElementById('ranking').textContent = data.ranking;
    }

    // Simulated data fetch (replace with actual data retrieval)
    function fetchActivityResults() {
        // This would typically come from your backend or activity system
        return {
            totalPoints: 250,
            timeTaken: 45,
            accuracy: 92,
            ranking: 'A'
        };
    }

    // Action button event listeners
    document.querySelector('.btn-primary').addEventListener('click', () => {
        // Navigate to next activity or page
        window.location.href = 'next-activity.html';
    });

    document.querySelector('.btn-secondary').addEventListener('click', () => {
        // Restart the activity
        window.location.href = 'current-activity.html';
    });

    // Initial results load
    const activityResults = fetchActivityResults();
    updateResults(activityResults);
});