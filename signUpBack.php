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
        $_SESSION["signupError"] = "Email is already in use. Please use a different email.";
        header("location:sign.html"); // Changed location to sign.html
        exit();
    }

    // Attempt to create the user
    if (createUser($conn, $username, $email, $password)) {
        // Redirect to appropriate page after successful sign-up
        header("location:success.php");
        exit();
    } else {
        $_SESSION["signupError"] = "Registration failed. Please try again.";
        header("location:sign.html"); // Changed location to sign.html
        exit();
    }
} else {
    header("location:sign.html"); // Changed location to sign.html
    exit();
}
?>
