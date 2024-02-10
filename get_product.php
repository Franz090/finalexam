<?php
include_once('./connections/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Fetch data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Generate HTML for displaying products
$html = "<h2>Product Information</h2>";

if ($result->num_rows > 0) {
    $html .= "<table border='1'>";
    $html .= "<tr>";
    $html .= "<th>Product Name</th>";
    $html .= "<th>Unit</th>";
    $html .= "<th>Price</th>";
    $html .= "<th>Expiry Date</th>";
    $html .= "<th>Available Inventory</th>";
    $html .= "<th>Available Inventory Cost</th>";
    $html .= "<th>Image</th>";
    // Add more table headers if needed
    $html .= "</tr>";

    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>";
        $html .= "<td>" . $row['name'] . "</td>";
        $html .= "<td>" . $row['unit'] . "</td>";
        $html .= "<td>$" . $row['price'] . "</td>";
        $html .= "<td>" . $row['expiry_date'] . "</td>";
        $html .= "<td>" . $row['inventory'] . "</td>";
        $html .= "<td>$" . ($row['inventory'] * $row['price']) . "</td>";

        // Display image using the <img> tag
        $html .= "<td><img src='" . $row['image'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";

        // Add more table data if needed
        $html .= "</tr>";
    }

    $html .= "</table>";
} else {
    $html .= "No products found";
}

$conn->close();

echo $html;
?>
