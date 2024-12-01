// Select necessary elements
const editButton = document.getElementById('edit-button');
const saveButton = document.getElementById('save-button');
const profileName = document.getElementById('profile-name');
const profileBio = document.getElementById('profile-bio');
const editName = document.getElementById('edit-name');
const editBio = document.getElementById('edit-bio');

// Edit button click event
editButton.addEventListener('click', () => {
    // Show editable fields
    editName.value = profileName.innerText; // Populate with current name
    editBio.value = profileBio.innerText;   // Populate with current bio

    editName.classList.remove('hidden');
    editBio.classList.remove('hidden');

    // Hide static text
    profileName.classList.add('hidden');
    profileBio.classList.add('hidden');

    // Show/Hide buttons
    saveButton.classList.remove('hidden');
    editButton.classList.add('hidden');
});

// Save button click event
saveButton.addEventListener('click', () => {
    // Update profile information with new values
    const newName = editName.value.trim();
    const newBio = editBio.value.trim();

    if (newName) profileName.innerText = newName;
    if (newBio) profileBio.innerText = newBio;

    // Hide editable fields
    editName.classList.add('hidden');
    editBio.classList.add('hidden');

    // Show static text
    profileName.classList.remove('hidden');
    profileBio.classList.remove('hidden');

    // Show/Hide buttons
    saveButton.classList.add('hidden');
    editButton.classList.remove('hidden');
});
