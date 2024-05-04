<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/products.css">
    <script src="https://kit.fontawesome.com/92d70a2fd8.js" crossorigin="anonymous"></script>
</head>

<body>
<div class="header">
    <p class="logo">LOGO</p>
    <div class="cart"><i class="fa-solid fa-cart-shopping"></i>
        <p id="count">0</p>
    </div>
</div>
<div class="container">
    <div id="root">
    </div>
    <div class="sidebar">
        <div class="head">
            <p>My cart</p>
        </div>
        <div id="cartItem">Your cart is empty</div>
        <div class="foot">
            <h3>Total</h3>
            <h2 id="total">$0.00</h2>
        </div>
    </div>
</div>
<?php
// Include database connection file
include_once 'connection.php';

// Fetch products from the database
$sql = "SELECT * FROM Products";
$result = $conn->query($sql);

// Check if there are products
if ($result->num_rows > 0) {
    // Output each product as HTML
    while ($row = $result->fetch_assoc()) {
        echo "<div class='box'>
                <div class='img-box'>
                    <img class='images' src='{$row['image']}' alt='Product Image'>
                </div>
                <div class='bottom'>
                    <p>{$row['productName']}</p>
                    <h2>{$row['price']}</h2>
                    <button onclick='addtocart({$row['productId']})'>Add to cart</button>
                </div>
              </div>";
    }
} else {
    echo "No products available";
}

// Close database connection
$conn->close();
?>
