<?php
session_start();

require_once 'phpfunctions.php';
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nameOnCard = $_POST['nameOnCard'];
    $cardNumber = $_POST['cardNumber'];
    $expMonth = $_POST['expMonth'];
    $expYear = $_POST['expYear'];
    $cvv = $_POST['cvv'];

    // Validate card number using Luhn algorithm
    if (!luhnCheck($cardNumber)) {
        echo '<script>
                alert("Invalid credit card number.");
                window.location.href = "pay.html";
              </script>';
        exit();
    }
    // Validate expiration date
    if (!isValidYear($expYear)) {
        echo '<script>
                alert("Invalid card expiration year.");
                window.location.href = "pay.html";
              </script>';
        exit();
    }

    // Validate CVV
    if (!isValidCVV($cvv)) {
        echo '<script>
                alert("Invalid CVV.");
                window.location.href = "pay.html";
              </script>';
        exit();
    }

    // Check if there are multiple transactions within the specified time frame
    if (CheckMultipleTransactions($conn, $cardNumber, 1)) {
        echo '<script>
                alert("Cannot proceed with another transaction at the moment.");
                window.location.href = "pay.html";
              </script>';
        exit();
    }

    // Insert payment card details into PaymentCards table
    $cardId = createPaymentCard($conn, $_SESSION['userId'], $cardNumber, $expYear, $expMonth, $cvv);

    if ($cardId) {
        // Insert payment details into Payments table
        $totalAmount = $_SESSION['totalAmount']; // Assuming total amount is stored in session
        if (createPayment($conn, $_SESSION['userId'], $cardId, $totalAmount)) {
            echo '<script>
                    alert("Payment successful.");
                    window.location.href = "index.php";
                  </script>';
            exit();
        } else {
            echo '<script>
                    alert("Failed to process payment. Please try again.");
                    window.location.href = "pay.html";
                  </script>';
            exit();
        }
    } else {
        echo '<script>
                alert("Failed to process payment. Please try again.");
                window.location.href = "pay.html";
              </script>';
        exit();
    }
} else {
    header("Location: pay.html");
    exit();
}
