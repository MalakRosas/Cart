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
// Function to validate credit card number using the Luhn algorithm
function luhnCheck($number) {
    $checksum = 0;
    $length = strlen($number);
    $first_digit = (int) substr($number, 0, 1); // Extract the first digit of the credit card number
    if ($length != 16 || ($first_digit != 4 && $first_digit != 5 && $first_digit != 3 && $first_digit != 2)) { //4->visa card 2,5->mastercard, american express numbers start with 3.
        return false;
    }
    for ($i = $length - 1; $i >= 0; $i--) { //looping from right to left 
        $digit = intval($number[$i]);
        if ($i % 2 == ($length % 2)) {
            $digit *= 2; //doubling every second digit
            if ($digit > 9) {// If the result of doubling a digit is greater than 9, then the two digits of the result are added together
                $digit -= 9;
            }
        }
        $checksum += $digit;
    }

    return $checksum % 10 == 0;
}
function isValidYear($year) {
    if (!is_numeric($year) || $year < 0) {
        return false;
    }
    // Get the current year
    $currentYear = date('Y');
    // Check if the year is in the future (greater than or equal to the current year)
    if ($year < $currentYear) {
        return false;
    }
    
    return true; // valid year 
}
function isValidCVV($cvv) {
    //must be 3 or 4 digits
    if (!is_numeric($cvv) || ($cvv < 0) || ($cvv < 100 || $cvv > 9999)) {
        return false;
    }
    return true; // valid cvv
}
 // a card number can not do more than one transaction per hour 
function CheckMultipleTransactions($conn, $cardNumber,$timeFrame) {
    $sql = "SELECT COUNT(*) AS transactionCount FROM payments WHERE card_number = ? AND transaction_date >= NOW() - INTERVAL ? HOUR";
    // Initialize a prepared statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false; //if SQL statement preparation fails
    } 
    mysqli_stmt_bind_param($stmt, "si", $cardNumber, $timeFrame);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    // Check if there are any transactions within the specified time
    return ($row['transactionCount'] > 0);
}
let slideIndex = 0;
const slides = document.querySelectorAll('.mySlides');

function showSlides() {
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';  
    }
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}    
    slides[slideIndex - 1].style.display = 'block';  
    setTimeout(showSlides, 1500); 
}

showSlides();

?>

