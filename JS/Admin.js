function showSection(sectionId) {
    const sections = document.querySelectorAll('.dashboard-card');
    sections.forEach(section => section.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
}

// Modal Creation and Functionality
function createModal() {
    const modal = document.createElement('div');
    modal.id = 'accountCreationModal';
    modal.innerHTML = `
        <style>
            #accountCreationModal {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0,0,0,0.4);
                justify-content: center;
                align-items: center;
            }
            .modal-content {
                background-color: #fefefe;
                padding: 20px;
                border-radius: 8px;
                width: 300px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            .modal-content h3 {
                color: #4CAF50;
                margin-bottom: 15px;
            }
            .modal-close {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
            }
        </style>
        <div class="modal-content">
            <h3>Account Created Successfully!</h3>
            <button class="modal-close" onclick="closeModal()">Close</button>
        </div>
    `;
    document.body.appendChild(modal);
}

function showModal() {
    const modal = document.getElementById('accountCreationModal');
    modal.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('accountCreationModal');
    modal.style.display = 'none';
}

// Account Creation Form Submission
document.addEventListener('DOMContentLoaded', function() {
    createModal(); // Initialize modal

    const accountCreationForm = document.getElementById('accountCreationForm');
    if (accountCreationForm) {
        accountCreationForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Collect form data
            const formData = new FormData(this);

            // Send data to create_account.php
            fetch('../Admin/process/create_account.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showModal(); // Show success modal
                    event.target.reset(); // Reset the form
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the account.');
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch and populate reports
    function loadReports() {
        fetch('fetch_reports.php')
            .then(response => response.json())
            .then(reports => {
                const tableBody = document.querySelector('#reportsSection tbody');
                tableBody.innerHTML = ''; // Clear existing rows

                reports.forEach(report => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${report.reportID}</td>
                        <td>${report.firstName} ${report.lastName}</td>
                        <td>${report.reportMessage}</td>
                        <td>${report.dateTime}</td>
                        <td>
                            <button onclick="replyToReport(${report.reportID})">Reply</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error loading reports:', error));
    }


   
});