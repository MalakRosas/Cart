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

?>

