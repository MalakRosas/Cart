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
$sql = "SELECT Users.userId, Users.username, Clients.city, Clients.state, Clients.phone_number FROM Users INNER JOIN Clients ON Users.userId = Clients.userId WHERE Users.UserType = 'Client'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Customer</title>
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
                                <td colspan="6">No customers available</td>
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
