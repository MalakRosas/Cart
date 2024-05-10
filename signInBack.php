<?php
session_start(); // Start the session to access session variables

require_once 'connection.php'; // Include the database connection file
require_once 'phpFunctions.php'; // Include the phpFunctions.php file

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signin"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($email === "admin@gmail.com" && $password === "admin1234") {
        header("Location: adminHome.html"); // Redirect to adminHome.html if credentials are "admin"
        exit();
    }
    // Call the loginUser function from phpFunctions.php
    $loginResult = loginUser($conn, $email, $password);
    if ($loginResult) {
        // After successful login
        $userId = getUserId($conn, $email); // Assuming you have a function to get userId by email
        $_SESSION['userId'] = $userId; // Store userId in the session

        // Redirect based on user type
        $userType = getUserType($conn, $email);
        if ($userType === 'Seller') {
            header("Location: addProduct.php"); // Redirect to addProduct.php if user type is Seller
            exit();
        } else {
            header("Location: index.php"); // Redirect to index.php for other user types
            exit();
        }
    } else {
        // Alert message for incorrect login credentials
        echo '<script>alert("Login failed. Invalid email or password!");
        window.location.href = "signin.html";
        </script>';
        exit();
    }
}
?>
