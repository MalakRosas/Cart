<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lorem Ipsum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        <h2>Lorem ipsum</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing</p>
    </section>
    <section id="product1" class="section-p1">
        <h2>CLASS A</h2>
        <p>It's Easy to shop! Lorem ipsum dolor sit amet</p>
        <div class="pro-container">
            <?php
            session_start();

            // Include your PHP connection file here
            include 'connection.php';
            include 'phpFunctions.php';

            // Fetch all products from the database
            $sql = "SELECT * FROM Products";
            $result = $conn->query($sql);

            // Check if there are any products
            if ($result->num_rows > 0) {
                // Loop through each row (product)
                while ($row = $result->fetch_assoc()) {
                    $productId = $row['productId'];
                    $productName = $row['productName'];
                    $description = $row['description'];
                    $price = $row['price'];
                    $quantity = $row['quantity'];
                    $image = $row['image'];
            ?>
                    <div class="pro">
                        <img src="<?php echo $image; ?>" alt="<?php echo $productName; ?>">
                        <div class="des">
                            <span><?php echo $productName; ?></span>
                            <h5><?php echo $description; ?></h5>
                            <div class="Star">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <h4 class="price"><?php echo $price; ?> L.E</h4>
                            <form action="" method="POST">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <input type="number" name="quantity" value="0" min="1">
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No products found.";
            }

            // Check if the add to cart button is clicked
            if (isset($_POST['add_to_cart'])) {
                $productId = $_POST['productId'];
                $quantity = $_POST['quantity'];
                $product = getProductById($conn, $productId);
                // Assuming $clientId is available, fetch it from session or database as needed
                // Assuming $userId is available, fetch it from session or database as needed
                $userId = $_SESSION['userId'];

                if ($product) {
                    addToCartAndUpdateQuantity($userId, $productId, $quantity, $product['price'], $conn);
                }
            }
            ?>
        </div>
    </section>
    <!-- Add more sections if needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="style/nindex.js"></script>
</body>

</html>