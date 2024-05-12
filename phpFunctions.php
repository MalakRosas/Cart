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
    $sql = "SELECT COUNT(*) AS transactionCount FROM Payments WHERE cardId = ? AND transaction_date >= NOW() - INTERVAL ? HOUR";
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
function getbrandId($conn, $brandName) {
    $stmt = $conn->prepare("SELECT brandId FROM Brands WHERE brandName = ?");
    $stmt->bind_param("s", $brandName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['brandId'];
    } else {
        return null; 
    }
}

function addProduct($conn, $sellerId, $productName, $description, $price, $quantity, $brandId, $image) {
    $sql = "INSERT INTO Products (sellerId, productName, description, price, quantity, brandId, image) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssiss", $sellerId, $productName, $description, $price, $quantity, $brandId, $image);
    
    if ($stmt->execute()) {
        return true; // Product added successfully
    } else {
        return false; // Unable to add product
    }
}

function addToCartAndUpdateQuantity($userId, $productId, $quantity, $unitPrice, $conn) {
    // Check if the product already exists in the cart for the user
    $stmt = $conn->prepare("SELECT * FROM Cart WHERE userId = ? AND productId = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product already exists in the cart, update the quantity
        $stmt = $conn->prepare("UPDATE Cart SET quantity = quantity + ? WHERE userId = ? AND productId = ?");
        $stmt->bind_param("iii", $quantity, $userId, $productId);
        $stmt->execute();
    } else {
        // Product doesn't exist in the cart, insert a new row
        $stmt = $conn->prepare("INSERT INTO Cart (userId, productId, quantity, unitPrice) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $userId, $productId, $quantity, $unitPrice);
        $stmt->execute();
    }

    // Update product quantity in the Products table
    $stmt = $conn->prepare("UPDATE Products SET quantity = quantity - ? WHERE productId = ?");
    $stmt->bind_param("ii", $quantity, $productId);
    $stmt->execute();
}

function getProductById($conn, $productId) {
    $sql = "SELECT * FROM Products WHERE productId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Handle SQL error
        return null;
    }
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row; // Return product data as an associative array
    } else {
        return null; // Product not found
    }
}


// Function to fetch cart items for a specific user
function getCartItems($conn, $userId) {
    $cartItems = array();
    // Fetch cart items for the given user ID from the database
    $sql = "SELECT Products.productId, Products.productName, Products.price, Cart.quantity 
            FROM Cart 
            INNER JOIN Products ON Cart.productId = Products.productId 
            WHERE Cart.userId = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Loop through each cart item and add it to the cartItems array
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    return $cartItems;
}



// Function to calculate the total price of items in the cart
function calculateTotalPrice($cartItems) {
    $totalPrice = 0;

    // Loop through each cart item and calculate its total price
    foreach ($cartItems as $cartItem) {
        // Check if the "price" key exists in the current cart item
        if (isset($cartItem['price'])) {
            // Assuming the price is stored in the 'price' column of the 'Products' table
            // Fetch the price of the product from the database and multiply it by the quantity
            $totalPrice += $cartItem['price'] * $cartItem['quantity'];
        }
    }

    return $totalPrice;
}

function removeFromCartAndAddToProducts($conn, $productId, $userId) {
    // Get the quantity of the product from the cart
    $sql_get_quantity = "SELECT quantity FROM Cart WHERE userId = ? AND productId = ?";
    $stmt_get_quantity = $conn->prepare($sql_get_quantity);
    $stmt_get_quantity->bind_param("ii", $userId, $productId);
    $stmt_get_quantity->execute();
    $result = $stmt_get_quantity->get_result();
    $row = $result->fetch_assoc();
    $quantity = $row['quantity'];

    // Remove product from Cart
    $sql_delete_cart = "DELETE FROM Cart WHERE userId = ? AND productId = ?";
    $stmt_delete_cart = $conn->prepare($sql_delete_cart);
    $stmt_delete_cart->bind_param("ii", $userId, $productId);
    $stmt_delete_cart->execute();

    // Increase product quantity in Products table
    $sql_increase_quantity = "UPDATE Products SET quantity = quantity + ? WHERE productId = ?";
    $stmt_increase_quantity = $conn->prepare($sql_increase_quantity);
    $stmt_increase_quantity->bind_param("ii", $quantity, $productId);
    $stmt_increase_quantity->execute();
}


// Get product details
function getProductDetails($conn, $productId) {
    $sql = "SELECT * FROM Products WHERE productId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $productDetails = $result->fetch_assoc();
    $stmt->close();
    return $productDetails;
}


function createOrder($conn, $orderDetails) {
    $sql = "INSERT INTO Orders (userId, totalPrice, status) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ids", $orderDetails['userId'], $orderDetails['totalPrice'], $orderDetails['status']);
    mysqli_stmt_execute($stmt);
    $orderId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    return $orderId;
}

function createOrderItem($conn, $orderItem) {
    $sql = "INSERT INTO OrderDetails (orderId, productId, quantity, unitPrice) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iiid", $orderItem['orderId'], $orderItem['productId'], $orderItem['quantity'], $orderItem['unitPrice']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return true;
}

function clearCart($conn, $userId) {
    $sql = "DELETE FROM Cart WHERE userId = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return true;
}
function getOrderForUser($conn, $userId) {
    // Query to fetch order for the given user ID
    $sql = "SELECT * FROM Orders WHERE userId = ? LIMIT 1";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return null;
    }

    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $order = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $order;
}

?>