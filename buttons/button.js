// Toggle sidebar when the menu icon is clicked
document.getElementById('menuIcon').addEventListener('click', function(event) {
    event.stopPropagation(); // Prevent the click from propagating to the body
    document.getElementById('sidebar').classList.toggle('open');
});

// Close the sidebar when clicking outside of it
document.body.addEventListener('click', function(event) {
    const sidebar = document.getElementById('sidebar');
    const menuIcon = document.getElementById('menuIcon');
    
    // Close sidebar if the click is outside of the sidebar and the menu icon
    if (!sidebar.contains(event.target) && !menuIcon.contains(event.target)) {
        sidebar.classList.remove('open');
    }
});

// Prevent clicks inside the sidebar from closing it
document.getElementById('sidebar').addEventListener('click', function(event) {
    event.stopPropagation();
});
