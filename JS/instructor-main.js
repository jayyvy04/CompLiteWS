// Function to render sections (to be used when sections are created)
function renderSections(sections) {
    const sectionsGrid = document.getElementById('sectionsGrid');
    sectionsGrid.innerHTML = ''; // Clear existing content

    if (sections.length === 0) {
        // If no sections, show empty state
        const emptyState = document.createElement('div');
        emptyState.classList.add('empty-sections');
        emptyState.innerHTML = `
            <p>No sections have been created yet.</p>
            <p>Go to the Sections page to create your first section.</p>
        `;
        sectionsGrid.appendChild(emptyState);
    } else {
        // Render sections
        sections.forEach(section => {
        const sectionCard = document.createElement('div');
        sectionCard.classList.add('section-card');
        sectionCard.innerHTML = `
    <div class="section-card-content">
        <h3>${section.name}</h3>
        <p>${section.subject}</p>
        <small>Section Code: ${section.code}</small>
    </div>
`;
            
            // View Section Details (placeholder)
            sectionCard.addEventListener('click', () => {
                alert(`Viewing details for ${section.name}`);
            });

            sectionsGrid.appendChild(sectionCard);
        });
    }
}

// Calendar Initialization
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 350,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        events: [
            { title: 'Web Dev Quiz', date: '2024-02-15' },
            { title: 'React Project Due', date: '2024-02-28' }
        ]
    });
    calendar.render();
});
document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    // Basic logout functionality
    localStorage.removeItem('currentUser');
    window.location.href = '/HTML/login.html'; // Redirect to login page
});

// Student News Tracker
class StudentNewsTracker {
    constructor() {
        this.studentNews = [];
    }

    addStudentNews(studentName, activity, timestamp) {
        const newsItem = {
            studentName,
            activity,
            timestamp
        };

        this.studentNews.unshift(newsItem);
        this.renderNews();
    }

    renderNews() {
        const newsContainer = document.getElementById('studentNews');
        newsContainer.innerHTML = '';

        this.studentNews.slice(0, 5).forEach(news => {
            const newsElement = document.createElement('div');
            newsElement.classList.add('news-item');
            newsElement.innerHTML = `
                <div class="news-item-content">
                    <strong>${news.studentName}</strong> ${news.activity}
                </div>
                <div class="news-item-date">
                    ${news.timestamp.toLocaleString()}
                </div>
            `;
            newsContainer.appendChild(newsElement);
        });
    }
}

// Initialize student news tracker
const newsTracker = new StudentNewsTracker();

// Simulate some student news
setTimeout(() => {
    newsTracker.addStudentNews(
        'Emily Johnson', 
        'completed React project in Web Development Fundamentals', 
        new Date()
    );
    newsTracker.addStudentNews(
        'Michael Chen', 
        'submitted assignment in Advanced React Programming', 
        new Date()
    );
}, 1000);

// Listener for sections from sections page
window.addEventListener('storage', (event) => {
    if (event.key === 'createdSections') {
        const sections = JSON.parse(event.newValue);
        renderSections(sections);
    }
});

// Check for existing sections on load
const existingSections = localStorage.getItem('createdSections');
if (existingSections) {
    renderSections(JSON.parse(existingSections));
}