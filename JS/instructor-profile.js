// Logout Functionality
document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    // Basic logout functionality
    localStorage.removeItem('currentUser');
    window.location.href = '/HTML/login.html'; // Redirect to login page
});

// Edit Profile Functionality
const editProfileBtn = document.getElementById('editProfileBtn');
const editProfileModal = document.getElementById('editProfileModal');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const editProfileForm = document.getElementById('editProfileForm');

// Profile Picture Upload
const uploadPictureInput = document.getElementById('upload-picture');
const profileImage = document.getElementById('profileImage');

// Edit Profile Modal Open
editProfileBtn.addEventListener('click', () => {
    // Populate current values
    document.getElementById('editFullName').value = document.getElementById('full-name').textContent;
    document.getElementById('editEmail').value = document.getElementById('email').textContent;
    document.getElementById('editSex').value = document.getElementById('sex').textContent;
    
    // Convert birth date to input date format
    const birthDate = document.getElementById('birth-date').textContent;
    const [month, day, year] = birthDate.split(/[, ]+/);
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const monthIndex = monthNames.indexOf(month);
    const formattedDate = `${year}-${String(monthIndex + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    document.getElementById('editBirthDate').value = formattedDate;

    editProfileModal.style.display = 'flex';
});

// Cancel Edit
cancelEditBtn.addEventListener('click', () => {
    editProfileModal.style.display = 'none';
});

// Save Profile Changes
editProfileForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Update profile details
    document.getElementById('full-name').textContent = document.getElementById('editFullName').value;
    document.getElementById('email').textContent = document.getElementById('editEmail').value;
    document.getElementById('sex').textContent = document.getElementById('editSex').value;

    // Convert date back to readable format
    const birthDate = document.getElementById('editBirthDate').value;
    const [year, month, day] = birthDate.split('-');
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const formattedDate = `${monthNames[parseInt(month) - 1]} ${day}, ${year}`;
    document.getElementById('birth-date').textContent = formattedDate;

    // Close modal
    editProfileModal.style.display = 'none';

    // Optional: Save to localStorage or send to backend
    const updatedProfile = {
        fullName: document.getElementById('editFullName').value,
        email: document.getElementById('editEmail').value,
        sex: document.getElementById('editSex').value,
        birthDate: formattedDate
    };
    localStorage.setItem('userProfile', JSON.stringify(updatedProfile));
});

// Profile Picture Upload
uploadPictureInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (event) => {
            profileImage.src = event.target.result;
            // Optional: Save image to localStorage
            localStorage.setItem('profilePicture', event.target.result);
        };
        reader.readAsDataURL(file);
    }
});

// Load saved profile and picture on page load
window.addEventListener('load', () => {
    // Load profile from localStorage
    const savedProfile = localStorage.getItem('userProfile');
    if (savedProfile) {
        const profile = JSON.parse(savedProfile);
        document.getElementById('full-name').textContent = profile.fullName;
        document.getElementById('email').textContent = profile.email;
        document.getElementById('sex').textContent = profile.sex;
        document.getElementById('birth-date').textContent = profile.birthDate;
    }

    // Load profile picture
    const savedProfilePicture = localStorage.getItem('profilePicture');
    if (savedProfilePicture) {
        profileImage.src = savedProfilePicture;
    }
});