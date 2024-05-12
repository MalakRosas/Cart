<?php
// Include database connection
require_once 'connection.php';

// Check if form is submitted for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seller_id'])) {
    $sellerID = $_POST['seller_id'];
    // Delete seller query
    $deleteQuery = "DELETE FROM Users WHERE userId = $sellerID";
    if ($conn->query($deleteQuery) === TRUE) {
        // If deletion is successful, redirect to the same page
        header("Location: adminSeller.php");
        exit;
    } else {
        // If deletion fails, display an error message
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch sellers from the database
$sql = "SELECT userId, username, email FROM Users WHERE UserType = 'Seller'";
$result = $conn->query($sql);
?>
<?php
// Include database connection
require_once 'connection.php';

// Check if form is submitted for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_id'])) {
    $customerID = $_POST['customer_id'];
    // Delete customer query
    $deleteQuery = "DELETE FROM Users WHERE userId = $customerID";
    if ($conn->query($deleteQuery) === TRUE) {
        // If deletion is successful, redirect to the same page
        header("Location: adminCustomer.php");
        exit;
    } else {
        // If deletion fails, display an error message
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch customers from the database
$sql = "SELECT Users.userId, Users.username, Users.email FROM Users WHERE Users.UserType = 'seller'"; # here ther are an error in database  Fatal error: Uncaught mysqli_sql_exception: Cannot delete or update a parent row: a foreign key constraint fails (`cart`.`products`, CONSTRAINT `products_ibfk_1` FOREIGN KEY (`sellerId`) REFERENCES `users` (`userId`)) in C:\xampp\htdocs\Cart\adminSeller.php:10 Stack trace: #0 C:\xampp\htdocs\Cart\adminSeller.php(10): mysqli->query('DELETE FROM Use...') #1 {main} thrown in C:\xampp\htdocs\Cart\adminSeller.php on line 10
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
                <a href="allProducts.php">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Products</h3>
                </a>
                <a href="adminSeller.php"class="active">
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

    <section class="SellerNav">
        <div class="Ab-cust">
            <div class="recent-order">
                <h2>Sellers :</h2>
                <table id="customerTable">
                    <thead>
                        <tr>
                            <th>Seller ID</th>
                            <th>Username</th>
                            <th>Email</th>
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
                                    <td><?php echo $row['email']; ?></td>
                                    <td>
                                        <form action="" method="post">
                                            <input type="hidden" name="seller_id" value="<?php echo $row['userId']; ?>">
                                               <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this seller?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="4">No sellers available</td>
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
