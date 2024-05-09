<?php
// Start the session
session_start();

// Include your PHP connection file here
include 'connection.php';
include 'phpFunctions.php';

// Get the user ID from the session
$userId = $_SESSION['userId'] ?? null;

// Fetch cart items for the user
$cartItems = [];
if ($userId) {
    $cartItems = getCartItems($conn, $userId);
}

// Calculate the total price of cart items
$totalPrice = calculateTotalPrice($cartItems);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Add your CSS stylesheets here -->
    <link rel="stylesheet" href="style/cart.css">
</head>

<body>
    <div class="header">
        <p class="logo">LOGO</p>
        <div class="cart"><i class="fa-solid fa-cart-shopping"></i>
            <!-- Display the count of cart items here -->
            <p id="count"><?php echo count($cartItems); ?></p>
        </div>
    </div>
    <div class="container">
        <div id="root">
            <!-- Display cart products here -->
            <?php foreach ($cartItems as $cartItem): ?>
                <div class="cart-item">
                    <p><?php echo $cartItem['productName']; ?></p>
                    <p>$<?php echo $cartItem['price']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="sidebar">
            <div class="head">
                <p>My cart</p>
            </div>
            <div id="cartItem">
                <!-- Display total price of cart items here -->
                <p>Total Price: $<?php echo $totalPrice; ?></p>
            </div>
            <div class="foot">
                <h3>Total</h3>
                <h2 id="total">$0.00</h2>
            </div>
        </div>
    </div>
    <!-- Add your JavaScript file here -->
    <script src="cart.js"></script>
</body>

</html>
