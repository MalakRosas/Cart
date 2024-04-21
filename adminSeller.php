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
    <title>Admin Seller</title>
    <link rel="stylesheet" href="style/adminSeller.css">
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

    <section class="SellerNav">
        <div class="Ab-cust">
            <div class="reservation-form">
                <h1>Sellers</h1>
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
                                               <button type="submit" onclick="return confirm('Are you sure you want to delete this seller?')">Delete</button>
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
</body>
</html>
