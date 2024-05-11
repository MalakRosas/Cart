const themeToggler = document.querySelector(".theme-toggler");

themeToggler.addEventListener('click', () => {
    // Toggling the dark mode class
    document.body.classList.toggle('dark-theme-variables');
});
// JavaScript code for interactive dashboard

document.addEventListener("DOMContentLoaded", function() {
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('btn_close');
    const sidebar = document.querySelector('aside');

    // Toggle sidebar visibility
    menuBtn.addEventListener('click', function() {
        sidebar.classList.toggle('active');
    });

    closeBtn.addEventListener('click', function() {
        sidebar.classList.remove('active');
    });

    // Theme toggler
    const themeToggler = document.querySelector('.theme-toggler');
    const body = document.querySelector('body');

    themeToggler.addEventListener('click', function() {
        body.classList.toggle('dark-theme');
        themeToggler.classList.toggle('active');
    });

    // Add more functionality as needed...
});
