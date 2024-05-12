<?php
// orderConfirmation.php

session_start();

require_once 'phpFunctions.php';
require_once 'connection.php';

// Redirect to cart page if total amount is not set in session
if (!isset($_SESSION['totalAmount'])) {
    header("Location: cart.php");
    exit;
}

$totalPrice = $_SESSION['totalAmount'];

// Get the user ID from the session
$userId = $_SESSION['userId'] ?? null;

// Fetch cart items for the user
$cartItems = [];
if ($userId) {
    $cartItems = getCartItems($conn, $userId);
}

// Check if cart is empty
if (empty($cartItems)) {
    // Display a JavaScript alert indicating that the cart is empty
    echo "<script>alert('Your cart is empty. Please add items to your cart before proceeding.');";
    // Redirect to cart.php after showing the alert
    echo "window.location = 'cart.php';";
    echo "</script>";
}

// Check if an order already exists for the user
$existingOrder = getOrderForUser($conn, $userId);

if ($existingOrder) {
    // Use the existing order ID
    $orderId = $existingOrder['orderId'];
} else {
    // Insert order details into Orders table
    $orderDetails = [
        'userId' => $userId,
        'totalPrice' => $totalPrice,
        'status' => 'pending' // Set default status as pending
    ];
    $orderId = createOrder($conn, $orderDetails);
}

// Insert order items into OrderDetails table
foreach ($cartItems as $cartItem) {
    $orderItem = [
        'orderId' => $orderId,
        'productId' => $cartItem['productId'],
        'quantity' => $cartItem['quantity'],
        'unitPrice' => $cartItem['price']
    ];
    createOrderItem($conn, $orderItem);
}

// Clear the cart for the user
clearCart($conn, $userId);

// Display order confirmation message
$message = "Your order has been confirmed! Order ID: $orderId";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style/nindex.css">
</head>

<body>
    <section id="header">
        <a href="#"><img src="style/images/index/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php" class="active">Shop</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="signin.html"><i class="fas fa-sign-in-alt"></i></a></li>
            </ul>
        </div>
    </section>
    <section id="page-header">
        <h1>ORDER CONFIRMATION</h1>
    </section>

    <section id="order-confirmation" class="section-p1">
    <div class="message-container">
            <p><?php echo $message; ?></p>
            <p>Your order details have been successfully processed. You will receive an email confirmation shortly.</p>
        </div>
    </section>

    <script src="style/nindex.js"></script>
</body>
<footer class="section-p1">
    <div class="col">
    <img src="style/images/index/logo.png" class="logo" class="logo" alt="">
    <h4>Contact</h4>
    <p><strong>Address: </strong> 562 Wellington Road, Street 32, San Francisco</
</p>
    <p><strong>Phone:</strong> +01 2222 365/(+91) 01 2345 6789</p>
    <p><strong>Hours:</strong> 10:00 - 18:00, Mon Sat</p>
    <div class="follow">
    <h4>Follow us</h4>
    <div class="icon">
    <i class="fab fa-facebook-f"></i>
    <i class="fab fa-twitter"></i>
    <i class="fab fa-instagram"></i>
    <i class="fab fa-pinterest-p"></i>
    <i class="fab fa-youtube"></i>
    </div>
    </div>
    </div>
            <div class="col">
        <h4>My Account</h4>
        <a href="signin.html">Sign In</a>
        <a href="cart.php">View Cart</a>
        <a href="shop.php">shopping</a>
        <a href="about.php">About</a>
        </div>
        <div class="col install">
        <h4>Install App</h4>
        <p>From App Store or Google Play</p>
        <div class="row">
        <img src="style/images/index/pay/app.jpg" alt="">
        <img src="style/images/index/pay/play.jpg" alt="">
        </div>
        <p>Secured Payment Gateways </p>
        <img src="style\images\index\pay\pay.png" alt="">
        </div>
        <div class="copyright">
        <p>@Perfect web programmers team ! </p>
        </div>
    </footer>

</html>