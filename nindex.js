// nindex.js
console.log("JavaScript file linked successfully!");

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Toggle navigation menu on small screens
const navbarToggle = document.getElementById('navbar-toggle');
const navbar = document.getElementById('navbar');

navbarToggle.addEventListener('click', () => {
    navbar.classList.toggle('active');
});

// Add any additional JavaScript functionality here
