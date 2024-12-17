        // Modal functionality
        const doneBtn = document.getElementById('doneBtn');
        const modal = document.getElementById('confirmationModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');

        // Show modal when Done button is clicked
        doneBtn.addEventListener('click', function() {
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        });

        // Close modal when Cancel is clicked
        cancelBtn.addEventListener('click', function() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        });

        // Redirect to activity page when Confirm is clicked
        confirmBtn.addEventListener('click', function() {
            window.location.href = '../HTML/inActivity.html';
        });

        // Close modal if clicked outside of it
        window.addEventListener('click', function(event) {
            if (event.target == modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }
        });