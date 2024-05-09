<?php
include 'connection.php';

// Check if productId and quantity are set
if (isset($_POST['productId'], $_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $unitPrice = $_POST['unitPrice'];

    // Insert the product into the Cart table
    $stmt = $conn->prepare("INSERT INTO Cart (productId, quantity, unitPrice) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $productId, $quantity, $unitPrice);
    
    if ($stmt->execute()) {
        echo "Product added to cart successfully!";
    } else {
        echo "Error adding product to cart: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>
