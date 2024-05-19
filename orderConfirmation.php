<?php
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

// Get the cardId from the session (assuming it's set during payment process)
$cardId = $_SESSION['cardId'] ?? null;

// Check if an order already exists for the user
$existingOrder = getOrderForUser($conn, $userId);

if ($existingOrder && $existingOrder['status'] === 'pending') {
    // Use the existing pending order ID
    $orderId = $existingOrder['orderId'];
} else {
    // Insert order details into Orders table
    $orderDetails = [
        'userId' => $userId,
        'totalPrice' => $totalPrice,
        'status' => 'pending', // Set default status as pending
        'shippingAddress' => $_SESSION['shippingAddress'], // Assuming shipping address is set during checkout
        'cardId' => $cardId // Pass the cardId here
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
        <div>
            <p><?php echo $message; ?></p>
            <p>Your order details have been successfully processed. You will receive an email confirmation shortly.</p>
        </div>
    </section>

    <script src="style/nindex.js"></script>
</body>

</html>