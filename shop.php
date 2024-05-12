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
        <a href="index.php"><img src="style/images/index/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php" class="active">Shop</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="signin.html"><i class="fas fa-sign-in-alt"></i></a></li>
            </ul>
        </div>
    </section>
    <section id="page-header">
        <h2>Let's Shopping</h2>
        <p>Shopping become easier now !</p>
    </section>
    <section id="product1" class="section-p1">
        <h2>Featured</h2>
        <p>It's Easy to shop! Lorem ipsum dolor sit amet</p>
        <div class="pro-container">
            <?php
            session_start();

            // Include your PHP connection file here
            include 'connection.php';
            // Fetch products with brand "Puma" from the database
            $sql = "SELECT * FROM Products WHERE feature != 'NULL'";
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
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                            </div>
                            <h4 class="price"><?php echo $price; ?> L.E</h4>
                            <form action="details.php" method="GET">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <button type="submit" name="view_details"><i class="fas fa-shopping-cart cart"></i></button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No Puma products found.";
            }
            ?>
        </div>
    </section>
    <section id="product2" class="section-p1">
        <h2>ADIDAS</h2>
        <p>It's Easy to shop! Lorem ipsum dolor sit amet</p>
        <div class="pro-container">
            <?php
            // Include your PHP connection file here
            include 'connection.php';
            // Fetch products with brand "MANGO" from the database
            $sql = "SELECT * FROM Products WHERE brandid = 3";
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
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                            </div>
                            <h4 class="price"><?php echo $price; ?> L.E</h4>
                            <form action="details.php" method="GET">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <button type="submit" name="view_details"><i class="fas fa-shopping-cart cart"></i></button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No MANGO products found.";
            }
            ?>
        </div>
    </section>
    <section id="product3" class="section-p1">
        <h2>MANGO</h2>
        <p>It's Easy to shop! Lorem ipsum dolor sit amet</p>
        <div class="pro-container">
            <?php
            // Include your PHP connection file here
            include 'connection.php';
            // Fetch products with brand "MANGO" from the database
            $sql = "SELECT * FROM Products WHERE brandid = 2";
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
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                                <i class="fas fa-star star-icon"></i>
                            </div>
                            <h4 class="price"><?php echo $price; ?> L.E</h4>
                            <form action="details.php" method="GET">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <button type="submit" name="view_details"><i class="fas fa-shopping-cart cart"></i></button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No MANGO products found.";
            }
            ?>
        </div>
    </section>
    <section id="product4" class="section-p1">
        <h2>Puma</h2>
        <p>It's Easy to shop! Lorem ipsum dolor sit amet</p>
        <div class="pro-container">
            <?php
            // Include your PHP connection file here
            include 'connection.php';
            // Fetch products with brand "MANGO" from the database
            $sql = "SELECT * FROM Products WHERE brandid = 1";
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
                            <form action="details.php" method="GET">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <button type="submit" name="view_details"><i class="fas fa-shopping-cart cart"></i></button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No MANGO products found.";
            }
            ?>
        </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="style/nindex.js"></script>
</body>

</html>
