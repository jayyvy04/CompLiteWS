// Modal functionality
document.addEventListener('DOMContentLoaded', () => {
    const addSectionBtn = document.getElementById('addSectionBtn');
    const addSectionModal = document.getElementById('addSectionModal');
    const closeModal = document.querySelector('.close-modal');

    // Open modal
    addSectionBtn.addEventListener('click', () => {
        addSectionModal.style.display = 'block';
    });

    // Close modal when clicking 'x'
    closeModal.addEventListener('click', () => {
        addSectionModal.style.display = 'none';
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === addSectionModal) {
            addSectionModal.style.display = 'none';
        }
    });
});