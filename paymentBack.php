<?php
session_start(); // Start the session to store error messages

require_once 'phpfunctions.php'; // Include the PHP functions file
require_once 'connection.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $nameOnCard = $_POST['nameOnCard'];
    $cardNumber = $_POST['cardNumber'];
    $expMonth = $_POST['expMonth'];
    $expYear = $_POST['expYear'];
    $cvv = $_POST['cvv'];

    // Validate form data (you can add more validation if needed)

    // Insert payment information into the database
    if (createPayment($conn, $name, $email, $address, $city, $state, $zip, $nameOnCard, $cardNumber, $expMonth, $expYear, $cvv)) {
        header("Location: index.php"); // Redirect to index.html after successful submission
        exit();
    } else {
        $_SESSION['paymentError'] = "Failed to process payment. Please try again."; // Set error message
        header("Location: paymentPage.php"); // Redirect back to the payment page with an error message
        exit();
    }
} else {
    header("Location: paymentPage.php"); // Redirect back to the payment page if accessed directly without form submission
    exit();
}
?>
