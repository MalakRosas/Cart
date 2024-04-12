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
    $expYear = $_POST['exspYear'];
    $cvv = $_POST['cvv'];

    // Validate ZIP code format
    $zip = (string)$zip;
    if (!preg_match("/^\d{5}$/", $zip)) { // ^ asserts the start of the string, \d matches any digit from 0 to 9 from 5 digits
        echo   '<script>
            alert("Invalid ZIP code format.")
            window.location.href = "pay.html";
        </script>';
        exit();
    }
    if (!luhnCheck($cardNumber)) {
        echo   '<script>
            alert("Invalid credit card number.")
            window.location.href = "pay.html";
        </script>';
        exit();
    }
    if(!isValidYear($expYear)){
        echo   '<script>
            alert("Invalid card expiration date.")
            window.location.href = "pay.html";
        </script>';
    }
    if(!isValidCVV($cvv)){
        echo   '<script>
            alert(" Invalid cvv.")
            window.location.href = "pay.html";
        </script>';
    }
    if (CheckMultipleTransactions($conn, $cardNumber, 1)) { // each one hour
        echo '<script>
        alert("Cannot proceed with another transaction at the moment.")
        window.location.href = "pay.html";
        </script>';
    } else {
        echo '<script>
        alert("Proceed with the transaction.")
        window.location.href = "pay.html";
        </script>';
    }    
    // Insert payment information into the database
    if (createPayment($conn, $name, $email, $address, $city, $state, $zip, $nameOnCard, $cardNumber, $expMonth, $expYear, $cvv)) {
        header("Location: index.php"); // Redirect to index.html after successful submission
        exit();  
    } else {
        $_SESSION['paymentError'] = "Failed to process payment. Please try again."; // Set error message
        header("Location: pay.html"); // Redirect back to the payment page with an error message
        exit();
    }
} else {
    header("Location: pay.html"); // Redirect back to the payment page if accessed directly without form submission
    exit();
}
?>