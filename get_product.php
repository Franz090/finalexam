<?php
include('./connections/db.php');
// Fetch data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Generate HTML for displaying products
$html = "<h2>Product Information</h2>";

if ($result->num_rows > 0) {
    $html .= "<ul>";
    while ($row = $result->fetch_assoc()) {
        $html .= "<li>";
        $html .= "Product Name: " . $row['name'] . "<br>";
        $html .= "Unit: " . $row['unit'] . "<br>";
        $html .= "Price: $" . $row['price'] . "<br>";
        $html .= "Expiry Date: " . $row['expiry_date'] . "<br>";
        $html .= "Available Inventory: " . $row['inventory'] . "<br>";
        $html .= "Available Inventory Cost: $" . ($row['inventory'] * $row['price']) . "<br>";
        // Add image display logic if you store image paths in the database
        $html .= "</li>";
    }
    $html .= "</ul>";
} else {
    $html .= "No products found";
}

$conn->close();

echo $html;
?>
