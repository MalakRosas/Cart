<?php
session_start();

require_once 'connection.php';
require_once 'phpfunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['userType']; // Assuming userType is passed from the form

    // Additional attributes for client users
    $clientAttributes = null;
    if ($userType === 'Client') {
        $clientAttributes = array(
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'phone_number' => $_POST['phone_number']
        );
    }

    if (emailUsed($conn, $email)) {
        echo '<script>
            alert("Email already exists.");
            window.location.href = "signup.html";
        </script>';
        exit();
    }

    if (createUser($conn, $username, $email, $password, $userType, $clientAttributes)) {
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
