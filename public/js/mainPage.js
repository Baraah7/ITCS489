// No JavaScript is needed for the main page currently.
// Add any future JavaScript functionality here.
// Function to check login status and update welcome section
function checkLoginStatus() {
    fetch('../app/controllers/mainPage_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        const welcomeSection = document.getElementById('welcomeSection');
        const userNameSpan = document.getElementById('userName');
        
        if (data.isLoggedIn) {
            welcomeSection.classList.remove('hidden');
            userNameSpan.textContent = data.userName;
        } else {
            welcomeSection.classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error checking login status:', error);
    });
}

// Check login status when page loads
document.addEventListener('DOMContentLoaded', () => {
    checkLoginStatus();
});
