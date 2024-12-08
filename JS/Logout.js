// logout.js
function logout() {
    // Send an AJAX request to destroy the session
    fetch('../Admin/process/logout.php', {
        method: 'POST',
        credentials: 'same-origin' // Important for sending cookies
    })
    .then(response => {
        if (response.ok) {
            // Clear any local storage or session data if needed
            localStorage.clear();
            sessionStorage.clear();
            
            // Redirect to the main index page
            window.location.href = '../index.html';
        } else {
            // Handle error if logout fails
            console.error('Logout failed');
            alert('Unable to logout. Please try again.');
        }
    })
    .catch(error => {
        console.error('Logout error:', error);
        alert('An error occurred during logout.');
    });
}

// Attach the logout function to the logout button if it exists
document.addEventListener('DOMContentLoaded', () => {
    const logoutButton = document.querySelector('.logout-btn');
    if (logoutButton) {
        logoutButton.addEventListener('click', logout);
    }
});