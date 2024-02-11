<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</head>
<body>
    <h2>Add Product</h2>
    <form id="productForm" action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" autocomplete="off" required>
    
        <label for="unit">Unit:</label>
        <input type="text" name="unit" id="unit" autocomplete="off" required>
    
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price" autocomplete="off" required>
    
        <label for="expiry_date">Expiry Date:</label>
        <input type="date" name="expiry_date" id="expiry_date" autocomplete="off" required>
    
        <label for="inventory">Available Inventory:</label>
        <input type="number" name="inventory" id="inventory" autocomplete="off" required>
    
        <label for="image">Product Image:</label>
        <input id="image" type="file" accept="image/*" name="image" autocomplete="off" required/>

        <button type="submit">Add Product</button>
    </form>
    
    <div id="productDisplay">
        <!-- Display information will be shown here -->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    
    <script src="js/script.js"></script>
   
</body>
</html>