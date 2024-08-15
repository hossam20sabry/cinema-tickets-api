document.addEventListener('DOMContentLoaded', function() {
    var dropdownButton = document.querySelector('.dropbtn');
    var dropdownContent = document.querySelector('.dropdown-content');

    dropdownButton.addEventListener('click', function() {
    dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
    });

    document.addEventListener('click', function(event) {
    if (!event.target.matches('.dropbtn')) {
        dropdownContent.style.display = 'none';
    }
    });

    document.getElementById('logout').addEventListener('click', function() {
    // Add your logout functionality here
    // alert('Logging out...');
    // You can replace the alert with your actual logout functionality
    });
});
