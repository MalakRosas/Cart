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
    <title>Admin Customer</title>
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

    <section class="CustomerNav">
        <div class="Ab-cust">
            <div class="reservation-form">
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
