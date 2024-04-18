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
        // After successful login
        $userId = getUserId($conn, $email); // Assuming you have a function to get userId by email
        $_SESSION['userId'] = $userId; // Store userId in the session

        // Redirect based on user type
        $userType = getUserType($conn, $email);
        if ($userType === 'Seller') {
            echo '<script>window.location.href = "addProduct.html";</script>'; // Redirect to addProduct.html if user type is Seller
        } else {
            echo '<script>window.location.href = "index.php";</script>'; // Redirect to index.php for other user types
        }
        exit();
    } else {
        // Alert message for incorrect login credentials
        echo '<script>alert("Login failed. Invalid email or password!");
        window.location.href = "signin.html";
        </script>';
    }
}

?>
