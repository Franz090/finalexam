<?php
include('./connections/db.php');

// Process form data and insert into the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $inventory = $_POST['inventory'];

    // Add more validation and sanitation as needed

    // Insert data into the database
    $sql = "INSERT INTO products (name, unit, price, expiry_date, inventory) 
            VALUES ('$name', '$unit', '$price', '$expiry_date', '$inventory')";

    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
