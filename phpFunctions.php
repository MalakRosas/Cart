<?php
function emailUsed($conn, $email){
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn); //initializes a new MySQL statement object using the provided database connection 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:Sign.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $email); //The "s" argument specifies that the parameter is a string. 
    //This binding helps prevent SQL injection attacks by separating the SQL code from the user input.
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if(mysqli_fetch_assoc($resultData)){ // Simplified condition
        return true; // Email is already used
    } else {
        return false; // Email is not used
    }
}

function createUser($conn, $username, $email, $password){
    $sql = "INSERT INTO users (username, email, `password`) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:frontSignup.php?error=sqlerror");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true; // User created successfully
}
function loginUser($conn, $email, $password) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            return true; // Successful login
        } else {
            return false; // Incorrect password
        }
    } else {
        return false; // User not found
    }
}

function createPayment($conn, $name, $email, $address, $city, $state, $zip, $nameOnCard, $cardNumber, $expMonth, $expYear, $cvv) {
    // Check if the card number is already used
    if (isCardNumberUsed($conn, $cardNumber)) {
        return false; // Card number already used
    }

    $sql = "INSERT INTO payments (name, email, address, city, state, zip, name_on_card, card_number, exp_month, exp_year, cvv)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; // SQL error
    }

    mysqli_stmt_bind_param($stmt, "sssssssssss", $name, $email, $address, $city, $state, $zip, $nameOnCard, $cardNumber, $expMonth, $expYear, $cvv);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true; // Payment successfully processed
}

function isCardNumberUsed($conn, $cardNumber) {
    $sql = "SELECT * FROM payments WHERE card_number = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return true; // Assume card is used in case of SQL error
    }

    mysqli_stmt_bind_param($stmt, "s", $cardNumber);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $row !== null; // Return true if card number is found (i.e., already used), false otherwise
}



?>

