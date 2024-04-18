<?php
function emailUsed($conn, $email){
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle SQL error
        return false;
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if(mysqli_fetch_assoc($result)){ 
        return true; // Email is already used
    } else {
        return false; // Email is not used
    }
}

function createUser($conn, $username, $email, $password, $userType, $clientAttributes = null){
    $sql = "INSERT INTO users (username, email, password, UserType) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle SQL error
        return false;
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $userType);
    mysqli_stmt_execute($stmt);
    $userId = mysqli_insert_id($conn); // Get the last inserted user ID
    mysqli_stmt_close($stmt);

    // If the user type is a client, insert client attributes into the Clients table
    if ($userType === 'Client' && is_array($clientAttributes)) {
        if (!insertClientAttributes($conn, $userId, $clientAttributes)) {
            // Handle error if client attributes insertion fails
            return false;
        }
    }

    return true; // User created successfully
}

function insertClientAttributes($conn, $userId, $clientAttributes) {
    $sql = "INSERT INTO Clients (userId, city, state, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle SQL error
        return false;
    }

    $city = $clientAttributes['city'];
    $state = $clientAttributes['state'];
    $phone_number = $clientAttributes['phone_number'];

    mysqli_stmt_bind_param($stmt, "isss", $userId, $city, $state, $phone_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    return true; // Client attributes inserted successfully
}

function getUserByEmail($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle SQL error
        return null;
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        return $row; // Return user data as an associative array
    } else {
        return null; // User not found
    }
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

function luhnCheck($number) {
    $number = str_replace(' ', '', $number); // Remove spaces from the card number
    $checksum = 0;
    $length = strlen($number);
    $parity = $length % 2;
    for ($i = 0; $i < $length; $i++) {
        $digit = intval($number[$i]);
        if ($i % 2 == $parity) {
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        $checksum += $digit;
    }
    return $checksum % 10 === 0;
}

function isValidYear($year) {
    $currentYear = date('Y');
    return (is_numeric($year) && $year >= $currentYear);
}

function isValidCVV($cvv) {
    return (is_numeric($cvv) && strlen($cvv) === 3);
}

function createPaymentCard($conn, $userId, $cardNumber, $expYear, $expMonth, $cvv) {
    $billingAddress = "N/A"; // Assuming billing address is not provided in the form
    $sql = "INSERT INTO PaymentCards (userId, cardNumber, expiryYear, expiryMonth, CVV, billingAddress) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "isssss", $userId, $cardNumber, $expYear, $expMonth, $cvv, $billingAddress);
    mysqli_stmt_execute($stmt);
    $cardId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    return $cardId;
}

function createPayment($conn, $userId, $cardId, $totalAmount) {
    $sql = "INSERT INTO Payments (userId, cardId, total_amount) 
            VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iid", $userId, $cardId, $totalAmount);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return true;
}

function CheckMultipleTransactions($conn, $cardNumber, $timeFrame) {
    $sql = "SELECT COUNT(*) AS transactionCount FROM Payments WHERE cardNumber = ? AND transaction_date >= NOW() - INTERVAL ? HOUR";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    } 
    mysqli_stmt_bind_param($stmt, "si", $cardNumber, $timeFrame);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return ($row['transactionCount'] > 0);
}
function getUserType($conn, $email) {
    // Prepare and execute the SQL query to retrieve the user type based on email
    $sql = "SELECT UserType FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows == 1) {
        // Fetch the row and return the user type
        $row = $result->fetch_assoc();
        return $row['UserType'];
    } else {
        // If no row is returned, return false (user not found)
        return false;
    }
}
function getUserId($conn, $email) {
    $stmt = $conn->prepare("SELECT userId FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['userId'];
    } else {
        return null; // Handle case where email is not found
    }
}
function getDepartmentId($conn, $departmentName) {
    $stmt = $conn->prepare("SELECT departmentId FROM Departments WHERE departmentName = ?");
    $stmt->bind_param("s", $departmentName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['departmentId'];
    } else {
        return null; //departmentName is not found
    }
}
function addProduct($conn,$sellerId, $productName, $description, $price,$quantity, $departmentId, $image){
    $sql = "INSERT INTO products(sellerId, productName, description, price, quantity, departmentId, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){ // -- > run this sql e
        header("location:addProduct.php?error=somethingWrong"); // if sql statement has any errors
        exit();
    }
}
?>
