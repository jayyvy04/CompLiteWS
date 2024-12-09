function openReplyModal(reportID) {
    document.getElementById('replyModal').style.display = 'block';
    document.getElementById('reportID').value = reportID;
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}

document.getElementById('replyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('reportID', document.getElementById('reportID').value);
    formData.append('replyMessage', document.getElementById('replyMessage').value);

    fetch('/process/report_reply.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeReplyModal();
            document.getElementById('successModal').style.display = 'block';
            document.getElementById('replyForm').reset();
        } else {
            alert('Failed to send reply. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});