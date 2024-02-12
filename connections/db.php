<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

// Create a new MySQLi object
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If there is an error, terminate the script and print an error message
    die("Connection failed: " . $conn->connect_error);
}

// If the connection is successful, print a success message
// echo "Connected successfully";


?>
