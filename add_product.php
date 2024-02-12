<?php
include_once('./connections/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    // Process form data and insert into the database
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $inventory = $_POST['inventory'];

    // Add more validation and sanitation as needed
    if (empty($price) || !is_numeric($price)) {
        return;
    }

    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {

    $targetDir = "uploads/";
    $image = $targetDir . basename($_FILES["image"]["name"]);
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    $maxFileSize = 10 * 1024 * 1024; // 10 MB (you can adjust this value)

    // Check file size
    if ($_FILES["image"]["size"] > $maxFileSize) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        // If everything is OK, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
            // Insert data into the database
            $sql = "INSERT INTO products (name, unit, price, expiry_date, inventory, image) 
                    VALUES ('$name', '$unit', '$price', '$expiry_date', '$inventory', '$image')";

            $result = $conn->query($sql);

            if ($result !== TRUE) {
                // Handle database insertion error
            }
        }
        }
    }
}

$conn->close();
?>
