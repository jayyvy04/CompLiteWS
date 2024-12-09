function openReplyModal(reportId, email) {
    document.getElementById('selectedReportId').value = reportId;
    document.getElementById('recipientEmail').value = email;
    document.getElementById('replyModal').style.display = 'block';
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'none';
}

document.getElementById('replyReportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);

    fetch('../process/process_report_reply.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeReplyModal();
            document.getElementById('confirmationModal').style.display = 'block';
        } else {
            alert('Failed to send reply: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending the reply.');
    });
});

// Close modal when clicking outside
window.onclick = function(event) {
    const replyModal = document.getElementById('replyModal');
    const confirmationModal = document.getElementById('confirmationModal');
    
    if (event.target == replyModal) {
        replyModal.style.display = 'none';
    }
    
    if (event.target == confirmationModal) {
        confirmationModal.style.display = 'none';
    }
}