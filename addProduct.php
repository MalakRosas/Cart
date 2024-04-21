<?php
session_start();
include ("connection.php");
include ("phpFunctions.php");

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
    $pdepartment = $_POST['departmentName']; // Assuming departmentName is provided in the form
    // Retrieve departmentId from the database based on departmentName
    $departmentId = getDepartmentId($conn, $pdepartment); // Assuming $conn is the database connection

    $targetDir = "style/images/products/";
    $targetFile = $targetDir . basename($_FILES["photo"]["name"]);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
        if (addProduct($conn, $sellerId, $pname, $pdescription, $price, $pquantity, $departmentId, $targetFile)) {
            header('Refresh:0.1; url=addProduct.html');
            echo '<script>window.alert("Product added successfully")</script>';
            exit();
        } else {
            echo "Error: Unable to add product.";
        }
    } else {
        echo "Error: File upload failed.";
    }
}
?>