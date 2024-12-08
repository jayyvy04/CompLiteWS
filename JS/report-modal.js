function fetchReports() {
    fetch('../process/fetch_reports.php')
    .then(response => response.json())
    .then(reports => {
        const tableBody = document.querySelector('#reportsSection tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        if (reports.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="4">No reports found</td></tr>';
            return;
        }

        reports.forEach(report => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${report.reportID}</td>
                <td>${report.title || 'Untitled Report'}</td>
                <td>${report.reportMessage}</td>
                <td>${report.dateTime}</td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => {
        console.error('Error fetching reports:', error);
    });
}

// Fetch reports when Reports section is shown
document.querySelector('button[onclick="showSection(\'reportsSection\')"]').addEventListener('click', fetchReports);