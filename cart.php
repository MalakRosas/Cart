<?php
session_start();

require_once 'phpFunctions.php';
require_once 'connection.php';

// Get the user ID from the session
$userId = $_SESSION['userId'] ?? null;

// Fetch cart items for the user
$cartItems = [];
if ($userId) {
    $cartItems = getCartItems($conn, $userId);
}

$totalPrice = calculateTotalPrice($cartItems);
$_SESSION['totalAmount'] = $totalPrice;

// Check if the "Remove & Add to Products" button is clicked
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    removeFromCartAndAddToProducts($conn, $productId, $userId);
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style/nindex.css">
</head>

<body>
    <section id="header">
        <a href="index.php"><img src="style/images/index/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php" >Shop</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="cart.php"class="active">Cart</a></li>
                <li><a href="signin.html"><i class="fas fa-sign-in-alt"></i></a></li>
            </ul>
        </div>
    </section>
    <section id="page-header">
        <h1>CART</h1>
        <p>only one step to pay ! keep track !!</p>
    </section>

    <section id="cart" class="section-p1">
    <table width="100%">
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $cartItem): ?>
                    <tr class="cart-item">
                        <td><?php echo $cartItem['productName']; ?></td>
                        <td><?php echo $cartItem['quantity']; ?></td>
                        <td>$<?php echo $cartItem['price']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="productId" value="<?php echo $cartItem['productId']; ?>">
                                <button type="submit" name="removeFromCart"><i class="fas fa-times-circle"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
        <!-- Button to confirm order -->
    </section>

    <section id="cart-add" class="section-p1">
    <div id="subtotal">
        <h3>Cart Totals</h3>
        <table>
            <tr>
                <td>Cart</td>
                <td>$<?php echo $totalPrice; ?></td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>Free</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong>$<?php echo $totalPrice; ?></strong></td>
            </tr>
        </table>
    </div>
    <section id="banner-2" class="section-m1">
        <h4>Attention!</h4>
        <h2>Add your card to complete !</h2>
        <button type="button" id="completeOrderBtn">Add card</button>

    </section>
<section class="section-m1">
    <form action="orderConfirmation.php" method="post" class="confirm-order-form">
        <input type="hidden" name="totalAmount" value="<?php echo $totalPrice; ?>">
        <button type="submit" name="confirmOrder" class="confirm-order-btn">Confirm Order</button>
    </form>
</section>
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
    <script>
    // JavaScript function to redirect to payment page
    function redirectToPaymentPage() {
        window.location.href = "pay.html";
    }

    // Add event listener to the button
    document.getElementById("completeOrderBtn").addEventListener("click", redirectToPaymentPage);
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="style/nindex.js"></script>
</body>

</html>
