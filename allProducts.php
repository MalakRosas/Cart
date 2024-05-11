<?php
// Include database connection
require_once 'connection.php';

// Fetch all products from the database
$sql = "SELECT Products.productId, Products.productName, Products.description, Products.price, Products.quantity, Products.image, Brands.brandName, Users.username AS sellerName
        FROM Products 
        INNER JOIN Brands ON Products.brandId = Brands.brandId
        INNER JOIN Users ON Products.sellerId = Users.userId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link rel="stylesheet" href="style/adminCustomer.css">
</head>
<body>
    <header>
        <a href="adminHome.html" class="logo">Admin</a>
        <nav class="navigation">
            <ul>
                <li><a href="adminHome.html"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="signin.html">Log-OUT</a></li>
            </ul>
        </nav>
    </header>

    <section class="ProductNav">
        <div class="Ab-cust">
            <div class="reservation-form">
                <h1>All Products</h1>
                <table id="productTable">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Department</th>
                            <th>Seller</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['productId']; ?></td>
                                    <td><?php echo $row['productName']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['quantity']; ?></td>
                                    <td><?php echo $row['brandName']; ?></td>
                                    <td><?php echo $row['sellerName']; ?></td>
                                    <td><img src="<?php echo $row['image']; ?>" alt="Product Image" width="100"></td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="8">No products available</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
