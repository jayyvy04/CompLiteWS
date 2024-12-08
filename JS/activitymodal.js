function openModal() {
    const modal = document.getElementById('activityModal');
    modal.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('activityModal');
    modal.style.display = 'none';
}

function proceedToActivity() {
    window.location.href = '/HTML/inActivity.html';
}

// Replace the original button's onclick with this
document.querySelector('.btn-wrapper button').onclick = openModal;

// Close modal if user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('activityModal');
    if (event.target === modal) {
        closeModal();
    }
}