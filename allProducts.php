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
    <title>Admin Dashboard</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="style/AdminDashboard.css">
</head>
<body>
<div class="container">
        <aside>
            <div class="top">
                <div class="logo">
                    <img src="style/images/logo.png" alt="Logo">
                    <h2>Lorem<span class="text-muted">ispum</span></h2>
                </div>
                <div class="close" id="btn_close">
                    <i class="material-icons-sharp">close</i>
                </div>
            </div>
            <div class="sidebar">
                <a href="adminDashboard.php" >
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="adminCustomer.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Customers</h3>
                </a>
                <a href="allProducts.php" class="active">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Products</h3>
                </a>
                <a href="adminSeller.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Sellers</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Log out</h3>
                </a>
            </div>
        </aside>
        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>

    <section class="ProductNav">
        <div class="Ab-cust">
            <div class="recent-order">
                <h2>Products : </h2>
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
// Include database connection
require_once 'connection.php';

// Fetch one product from the database
$sql = "SELECT Products.productId, Products.productName, Products.description, Products.price, Products.quantity, Products.image, Brands.brandName, Users.username AS sellerName
        FROM Products 
        INNER JOIN Brands ON Products.brandId = Brands.brandId
        INNER JOIN Users ON Products.sellerId = Users.userId"; // Limiting to one row
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- head section -->
</head>
<body>
    <!-- body content -->
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
    </section>
                    </main>
                            <!-- Right sidebar -->
        <div class="right">
            <!-- Right sidebar content -->
            <div class="top">
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
                <div class="theme-toggler">
                    <span class="material-icons-sharp">light_mode</span>
                    <span class="material-icons-sharp active">dark_mode</span>

                </div>
                <div class="profile">
                    <div class="info">
                        <p>Hey, <b>Admin</b></p>
                        <small class="text-muted">Hello world</small>
                    </div>
                    <div class="profile-photo">
                        <img src="style/icon.png">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
