class SectionManager {
    constructor() {
        this.sections = this.loadSections();
        this.setupEventListeners();
        this.renderSections();
        this.setupLogout();
    }

    setupEventListeners() {
        const createSectionBtn = document.getElementById('createSectionBtn');
        const createSectionModal = document.getElementById('createSectionModal');
        const createSectionForm = document.getElementById('createSectionForm');

        createSectionBtn.addEventListener('click', () => {
            createSectionModal.style.display = 'flex';
        });

        createSectionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            this.createSection(
                document.getElementById('sectionName').value,
                document.getElementById('sectionSubject').value
            );
        });

        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                this.hideModal(e.target.id);
            }
        });
    }

    setupLogout() {
        const logoutBtn = document.getElementById('logoutBtn');
        logoutBtn.addEventListener('click', () => {
            // Basic logout functionality
            localStorage.removeItem('currentUser');
            window.location.href = '/HTML/login.html'; // Redirect to login page
        });
    }

    loadSections() {
        const savedSections = localStorage.getItem('createdSections');
        return savedSections ? JSON.parse(savedSections).map(section => ({
            ...section,
            createdDate: new Date(section.createdDate)
        })) : [];
    }

    generateSectionCode() {
        return Math.random().toString(36).substring(2, 8).toUpperCase();
    }

    createSection(name, subject) {
        const newSection = {
            id: Date.now(),
            name: name,
            subject: subject,
            code: this.generateSectionCode(),
            createdDate: new Date(),
            students: [],
            createdBy: this.getCurrentUser()
        };

        this.sections.push(newSection);
        this.saveSections();
        this.renderSections();
        this.hideModal('createSectionModal');
    }

    getCurrentUser() {
        return JSON.parse(localStorage.getItem('currentUser')) || { role: 'instructor' };
    }

    saveSections() {
        localStorage.setItem('createdSections', JSON.stringify(this.sections));
    }

    renderSections() {
        const tableBody = document.getElementById('sectionsTableBody');
        tableBody.innerHTML = '';

        this.sections.forEach(section => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${section.name}</td>
                <td>${section.code}</td>
                <td>${section.subject}</td>
                <td>${section.createdDate.toLocaleDateString()}</td>
                <td>
                    <button class="action-btn view-btn" onclick="sectionManager.viewStudents(${section.id})">
                        View Students
                    </button>
                    <button class="action-btn delete-btn" onclick="sectionManager.deleteSection(${section.id})">
                        Delete
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    deleteSection(sectionId) {
        this.sections = this.sections.filter(section => section.id !== sectionId);
        this.saveSections();
        this.renderSections();
    }

    viewStudents(sectionId) {
        const section = this.sections.find(s => s.id === sectionId);
        const studentsModal = document.getElementById('studentsModal');
        const studentsTitle = document.getElementById('sectionStudentsTitle');
        const studentsList = document.getElementById('sectionStudentsList');

        studentsTitle.textContent = `Students in ${section.name}`;
        studentsList.innerHTML = '';

        section.students.forEach(student => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${student.name}</td>
                <td>${student.grade}</td>
                <td>${student.points}</td>
                <td>
                    <button class="action-btn delete-btn">Remove</button>
                </td>
            `;
            studentsList.appendChild(row);
        });

        studentsModal.style.display = 'flex';
    }

    hideModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
}

// Initialize section manager
const sectionManager = new SectionManager();