<?php
session_start(); // Start the session to access session variables

require_once 'connection.php'; // Include the database connection file
require_once 'phpfunctions.php'; // Include the phpfunctions.php file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email is already used
    if (emailUsed($conn, $email)) {
        // Email is already in use, set error message in session
        echo   '<script>
            alert("Email already exists.")
            window.location.href = "signup.html";
        </script>';
        exit();
    }
    // Attempt to create the user
    if (createUser($conn, $username, $email, $password)) {
        // Redirect to appropriate page after successful sign-up
        header("location:signin.html");
        exit();
    } else {
        $_SESSION["signupError"] = "Registration failed. Please try again.";
        header("location:signup.html");
        exit();
    }
} else {
    header("location:signup.html");
    exit();
}

?>
