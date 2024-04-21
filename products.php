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
                                <h2>\${$row['price']}.00</h2>
                                <button onclick='addtocart(\"{$row['productName']}\", {$row['price']})'>Add to cart</button>
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

        function addtocart(productName, price) {
            cart.push({ title: productName, price: price });
            displaycart();
        }

        function delElement(a) {
            cart.splice(a, 1);
            displaycart();
        }

        function displaycart() {
            let j = 0,
                total = 0;
            document.getElementById("count").innerHTML = cart.length;
            if (cart.length == 0) {
                document.getElementById('cartItem').innerHTML = "Your cart is empty";
                document.getElementById("total").innerHTML = "$ " + 0 + ".00";
            } else {
                document.getElementById("cartItem").innerHTML = cart.map((items) => {
                    var { title, price } = items;
                    total = total + price;
                    document.getElementById("total").innerHTML = "$ " + total + ".00";
                    return (
                        `<div class='cart-item'>
                        <p style='font-size:12px;'>${title}</p>
                        <h2 style='font-size: 15px;'>$ ${price}.00</h2>` +
                        "<i class='fa-solid fa-trash' onclick='delElement(" + (j++) + ")'></i></div>"
                    );
                }).join('');
            }
        }
    </script>
</body>

</html>
