<?php
include_once('./connections/db.php'); // Include your database connection file

// Check if the request method is POST and the ID parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Sanitize the input to prevent SQL injection
    $productId = mysqli_real_escape_string($conn, $_POST["id"]);

    // Construct the SQL query to delete the product
    $sql = "DELETE FROM products WHERE id = '$productId'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Product deleted successfully
        echo "Product deleted successfully";
    } else {
        // Error occurred while deleting the product
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Handle invalid request
    echo "Invalid request";
}

// Close the database connection
$conn->close();
?>
