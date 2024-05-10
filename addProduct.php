<?php
session_start();
include("connection.php");
include("phpFunctions.php");

// Check if form is submitted
if (isset($_POST['add'])) {
    // Retrieve seller ID from session
    if (isset($_SESSION['userId'])) {
        $sellerId = $_SESSION['userId'];
    } else {
        echo "User is not logged in";
        exit(); // Exit to stop further execution
    }

    $pname = $_POST['productName'];
    $pdescription = $_POST['description'];
    $price = $_POST['price'];
    $pquantity = $_POST['quantity'];
    $pdepartment = $_POST['brands']; 
    // Retrieve departmentId from the database based on departmentName
    $departmentId = getDepartmentId($conn, $pdepartment); // Assuming $conn is the database connection

    $targetDir = "style/images/products/";
    $targetFile = $targetDir . basename($_FILES["photo"]["name"]);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        if (addProduct($conn, $sellerId, $pname, $pdescription, $price, $pquantity, $departmentId, $targetFile)) {
            header('Refresh:0.1; url=addProduct.php');
            echo '<script>window.alert("Product added successfully")</script>';
            exit();
        } else {
            echo "Error: Unable to add product.";
        }
    } else {
        echo "Error: File upload failed.";
    }
}

// Fetch department names from the Departments table
$departmentQuery = "SELECT brandName FROM Brands";
$departmentResult = mysqli_query($conn, $departmentQuery);

// Check if department query executed successfully
if ($departmentResult) {
    $departments = array();
    // Fetch each department name and store it in an array
    while ($row = mysqli_fetch_assoc($departmentResult)) {
        $departments[] = $row['brandName'];
    }
} else {
    // Handle error if department query fails
    echo "Error: " . mysqli_error($conn);
}

// Fetch seller usernames from the Users table where UserType is 'Seller'
$sellerQuery = "SELECT username FROM Users WHERE UserType = 'Seller'";
$sellerResult = mysqli_query($conn, $sellerQuery);

// Check if seller query executed successfully
if ($sellerResult) {
    $sellers = array();
    // Fetch each seller username and store it in an array
    while ($row = mysqli_fetch_assoc($sellerResult)) {
        $sellers[] = $row['username'];
    }
} else {
    // Handle error if seller query fails
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add product</title>
    <link rel="stylesheet" href="style/addProduct.css">
</head>

<body>
    <div class="topnav">
        <a class="active" href="index.php">Home</a>
        <a href="about.html">About</a>
        <a href="categories.html">Categories</a>
        <a href="offers.html">Offers</a>
        <a href="cart.html">Shopping Cart</a>
        <a href="account.html" class="account">Account</a>
        <a href="signup.html" class="account">Sign-Up</a>
        <a href="signin.html" class="account">Sign-In</a>
    </div>

    <form method="post" class="add" enctype="multipart/form-data">
        <p>Product name:</p>
        <input class="value" type="text" name="productName" placeholder="Product name" required><br>

        <p>Brand:</p>
        <select class="value" name="brand" required>
        <option value="" disabled selected>Choose brand</option>
            <?php
            foreach ($departments as $department) {
                echo "<option value='" . $department . "'>" . $department . "</option>";
            }
            ?>
        </select><br>
        <p>Seller:</p>
            <select class="value" name="seller" required>
            <option value="" disabled selected>Choose seller</option>
            <?php
            foreach ($sellers as $seller) {
                echo "<option value='" . $seller . "'>" . $seller . "</option>";
            }
            ?>
        </select><br>
        <p>Description:</p>
        <input class="value" type="text" name="description" placeholder="Description" required><br>

        <p>Price:</p>
        <input class="value" type="text" name="price" placeholder="Price" required><br>

        <p>Quantity:</p>
        <input class="value" type="text" name="quantity" placeholder="Quantity" required><br>

        <p>Image:</p>
        <input class="value" type="file" name="photo" id="photo" accept="image/*">

        <button id="myButton" name="add" class="button">Add product</button>
    </form>

</body>

</html>
