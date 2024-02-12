<?php
include_once('./connections/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateName"])) {
    // Process form data and update the product in the database
    $id = $_POST['id']; // Assuming you are passing the product ID through the form
    $name = $_POST['updateName'];
    $unit = $_POST['updateUnit'];
    $price = $_POST['updatePrice'];
    $expiry_date = $_POST['updateExpiryDate'];
    $inventory = $_POST['updateInventory'];

    // Add more validation and sanitation as needed
    if (empty($price) || !is_numeric($price)) {
        return;
    }

    // Handle image upload if provided
    if (!empty($_FILES["updateImage"]["name"])) {
        // Similar image handling logic as in the add_product.php file
    }

    // Update the product in the database
    $sql = "UPDATE products 
            SET name='$name', unit='$unit', price='$price', expiry_date='$expiry_date', inventory='$inventory' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error updating product: " . $conn->error;
    }
}

$conn->close();
?>