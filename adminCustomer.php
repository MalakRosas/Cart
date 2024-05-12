<?php
// Include database connection
require_once 'connection.php';

// Fetch customers from the database along with their associated products
$sql = "SELECT Users.userId, Users.username, Clients.city, Clients.state, Clients.phone_number, Products.productId, Products.productName 
        FROM Users 
        INNER JOIN Clients ON Users.userId = Clients.userId 
        INNER JOIN Cart ON Users.userId = Cart.userId 
        INNER JOIN Products ON Cart.productId = Products.productId 
        WHERE Users.UserType = 'Client'";
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
                <a href="adminCustomer.php"class="active">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Customers</h3>
                </a>
                <a href="allProducts.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Products</h3>
                </a>
                <a href="adminSeller.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Sellers</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Lorem_ipsum 5</h3>
                </a>
            </div>
        </aside>
        <main>
            <h1>Dashboard</h1>
            <div class="date">
                <input type="date">
            </div>

    <section class="CustomerNav">
        <div class="Ab-cust">
            <div class="recent-order">
                <h1>Customers</h1>
                <table id="customerTable">
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Username</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Phone Number</th>
                            <th>Product ID</th>
                            <th>Product Name</th> 
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?php echo $row['userId']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['state']; ?></td>
                                    <td><?php echo $row['phone_number']; ?></td>
                                    <td><?php echo $row['productId']; ?></td> 
                                    <td><?php echo $row['productName']; ?></td> 
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="customer_id" value="<?php echo $row['userId']; ?>">
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this customer?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="8">No customers available</td>
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
