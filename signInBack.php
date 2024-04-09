<?php
session_start(); // Start the session to access session variables

require_once 'connection.php'; // Include the database connection file
require_once 'Phpfunctions.php'; // Include the Phpfunctions.php file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signin"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the loginUser function from Phpfunctions.php
    $loginResult = loginUser($conn, $email, $password);

    if ($loginResult) {
        header("location: index.php"); // Redirect to index.php if login is successful
        exit();
    } else {
        $_SESSION["signinError"] = "Incorrect email or password.";
        echo "<script>alert('Incorrect email or password. Please try again.');</script>"; // Show warning alert
        header("location: sign.html"); // Redirect back to sign-in page
        exit();
    }
} else {
    header("location: sign.html"); // Redirect back to sign-in page if accessed directly without form submission
    exit();
}
?>
