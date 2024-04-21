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
            <?php
            include_once 'connection.php';
            include_once 'phpfunctions.php'; // Include phpfunctions.php

            // Check if a product is added to cart
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['productId']) && isset($_POST['quantity'])) {
                    $userId = 1; // Assuming userId 1 for demonstration, you should get the actual userId from session or authentication
                    $productId = $_POST['productId'];
                    $quantity = $_POST['quantity'];

                    // Check if quantity exceeds available quantity
                    $stmt = $conn->prepare("SELECT quantity FROM Products WHERE productId = ?");
                    $stmt->bind_param("i", $productId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $quantityAvailable = $row['quantity'];
                        if ($quantity <= $quantityAvailable) {
                            $unitPrice = $_POST['unitPrice'];
                            addToCartAndUpdateQuantity($userId, $productId, $quantity, $unitPrice, $conn); // Use addToCartAndUpdateQuantity function from phpfunctions.php
                        } else {
                            echo "<script>alert('Exceeds available quantity!');</script>";
                        }
                    }
                }
            }

            // Display products
            $sql = "SELECT * FROM Products";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='box'>
                            <div class='img-box'>
                                <img class='images' src='{$row['image']}' alt='Product Image'>
                            </div>
                            <div class='bottom'>
                                <p>{$row['productName']}</p>
                                <h2>\${$row['price']}.00</h2>
                                <p>Available Quantity: {$row['quantity']}</p>
                                <button onclick='addtocart({$row['productId']}, {$row['price']}, {$row['quantity']})'>Add to cart</button>
                            </div>
                          </div>";
                }
            } else {
                echo "<div class='box'>
                        <div class='img-box'>
                            <img class='images' src='image/placeholder.jpg' alt='Placeholder Image'>
                        </div>
                        <div class='bottom'>
                            <p>No products available</p>
                        </div>
                      </div>";
            }

            // Close database connection
            $conn->close();
            ?>
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

    <script>
        var cart = [];

        function addtocart(productId, price, availableQuantity) {
            // Prompt the user to enter the quantity
            var quantity = prompt("Enter quantity (Available: " + availableQuantity + "):");
            if (quantity === null || quantity === "") {
                return; // If the user cancels or enters nothing, do nothing
            }

            // Convert quantity to integer
            quantity = parseInt(quantity);

            // Check if the entered quantity is less than or equal to available quantity
            if (quantity <= availableQuantity) {
                // Add the product to cart
                cart.push({ productId: productId, price: price, quantity: quantity });
                displaycart();

                // Send AJAX request to add product to cart
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "products.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("productId=" + productId + "&quantity=" + quantity + "&unitPrice=" + price);
            } else {
                alert("Exceeds available quantity!");
            }
        }

        function delElement(productId) {
            let index = cart.findIndex(item => item.productId === productId);
            if (index !== -1) {
                cart.splice(index, 1);
                displaycart();
            }
        }

        function displaycart() {
            let total = 0;
            document.getElementById("count").innerHTML = cart.length;
            if (cart.length == 0) {
                document.getElementById('cartItem').innerHTML = "Your cart is empty";
                document.getElementById("total").innerHTML = "$ " + 0 + ".00";
            } else {
                document.getElementById("cartItem").innerHTML = cart.map((item) => {
                    var { productId, price, quantity } = item;
                    total += price * quantity;
                    return (
                        `<div class='cart-item'>
                            <p style='font-size:12px;'>Product ${productId} (Quantity: ${quantity})</p>
                            <h2 style='font-size: 15px;'>$ ${(price * quantity).toFixed(2)}</h2>
                            <i class='fa-solid fa-trash' onclick='delElement(${productId})'></i>
                        </div>`
                    );
                }).join('');
                document.getElementById("total").innerHTML = "$ " + total.toFixed(2);
            }
        }
    </script>
</body>

</html>
