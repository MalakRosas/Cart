<?php
session_start();

// Include your PHP connection file here
include 'connection.php';
include 'phpFunctions.php';

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // If the user is not logged in, set an error message and redirect to the sign-in page
    $_SESSION['errorMessage'] = "You need to sign in to add items to your cart.";
    header("Location: signin.html");
    exit();
}

// Check if the add to cart button is clicked
if (isset($_POST['add_to_cart'])) {
    // Process the form submission
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $product = getProductById($conn, $productId);

    // Check if the product exists and its quantity is greater than zero
    if ($product && $product['quantity'] > 0) {
        // Assuming $userId is available, fetch it from session or database as needed
        $userId = $_SESSION['userId'];
        addToCartAndUpdateQuantity($userId, $productId, $quantity, $product['price'], $conn);
    } else {
        // If the product quantity is zero or the product doesn't exist, set an error message and redirect back to the product page
        $_SESSION['errorMessage'] = "This product is out of stock.";
        header("Location: details.php?productId=" . $productId);
        exit();
    }
}

// Check if the "Remove & Add to Products" button is clicked
if (isset($_POST['removeFromCart'])) {
    $productId = $_POST['productId'];
    removeFromCartAndAddToProducts($conn, $productId, $userId);
    // Redirect back to the cart page after removing the item
    header("Location: cart.php");
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lorem Ipsum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style/nindex.css">

    <style>
        /* Style for the error message box */
        #error-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #070707;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            border-radius: 5px;
            z-index: 9999;
            text-align: center;
        }

        /* Style for the Cancel and Sign In buttons */
        .error-buttons {
            margin-top: 20px;
        }

        .error-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            background-color: #a74f78;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .error-buttons button:hover {
            background-color: #faaed2;
        }
    </style>
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
    <section id="prodetails" class="section-p1">
        <div class="single-pro-image">
            <img src="style/images/index/products/f1.jpg" width="100%" id="MainImg" alt="">
            <div class="small-img-group">
                <div class="small-img-col">
                    <img src="style/images/index/products/f1.jpg" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="style/images/index/products/f2.jpg" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="style/images/index/products/f3.jpg" width="100%" class="small-img" alt="">
                </div>
                <div class="small-img-col">
                    <img src="style/images/index/products/f4.jpg" width="100%" class="small-img" alt="">
                </div>
            </div>
        </div>

        <div class="single-pro-details">
            <?php
            // Fetch product details based on productId
            $productId = $_GET['productId']; // Assuming productId is passed through URL
            $product = getProductById($conn, $productId);

            if ($product) {
                $productName = $product['productName'];
                $description = $product['description'];
                $price = $product['price'];
            ?>
                <h4><?php echo $productName; ?></h4>
                <h4><?php echo $description; ?></h4>
                <h1><?php echo $price; ?> L.E</h1>
                <form action="" method="POST">
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                    <input type="number" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="normal">Add to Cart</button>
                </form>
                <h4>lorem ipsum</h4>
                <span>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vitae gravida nibh, eu scelerisque ex. Aliquam cursus nunc vel nunc consequat fringilla. Duis feugiat rutrum pharetra. Suspendisse potenti. Nam dictum posuere arcu, et finibus sem ullamcorper id. Pellentesque aliquam ornare interdum. Aenean molestie massa nulla, quis blandit libero fringilla id. Nunc gravida, nulla eget pellentesque aliquam, turpis augue sodales felis, eget feugiat augue nibh at velit. Nunc bibendum augue ac mauris porta scelerisque.
                </span>
                <!-- Add the form for removing from cart -->
                <form method="post">
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                    <button type="submit" name="removeFromCart">Remove & Add to Products</button>
                </form>
            <?php
            } else {
                echo "<p>Product not found.</p>";
            }
            ?>
        </div>

        <?php if (isset($_SESSION['errorMessage'])): ?>
            <div id="error-message">
                <p><?php echo $_SESSION['errorMessage']; ?></p>
                <div class="error-buttons">
                    <button onclick="closeErrorMessage()">Cancel</button>
                    <a href="signin.html"><button>Sign In</button></a>
                </div>
            </div>
        <?php
            unset($_SESSION['errorMessage']); // Clear the error message after displaying it
        endif;
        ?>
    </section>

    <script>
        function closeErrorMessage() {
            document.getElementById('error-message').style.display = 'none';
        }
    </script>
</body>

</html>
