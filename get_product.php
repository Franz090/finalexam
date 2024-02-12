<?php
include_once('./connections/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Fetch data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Generate HTML for displaying products
$html = "<div class='container'>";
$html .= "<div class='row'>";
$html .= "<div class='col-6'><h2>Product Information</h2></div>";
$html .= "<div class='col-6 text-end'><button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#exampleModal' data-bs-whatever='@mdo'>Add Product</button></div>";
$html .= "</div>"; // End of row
$html .= "<table id='myTable'  border='1' class='table table-striped table-responsive' style='width:100%'>";
$html .= "<thead>";
$html .= "<tr>";
$html .= "<th>Product Name</th>";
$html .= "<th>Unit</th>";
$html .= "<th>Price</th>";
$html .= "<th>Expiry Date</th>";
$html .= "<th>Available Inventory</th>";
$html .= "<th>Available Inventory Cost</th>";
$html .= "<th>Image</th>";
$html .= "<th>Action</th>"; // New column for actions
// Add more table headers if needed
$html .= "</tr>";
$html .= "</thead>";
$html .= "<tbody>";

if ($result->num_rows > 0) {
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
        // Add update and delete buttons
        $html .= "<td>";
        $html .= "<button>Update</button>  ";
        $html .= "<button>Delete</button>";
        $html .= "</td>";
        // Add more table data if needed
        $html .= "</tr>";
    } 
} 

$html .= "</tbody>";
$html .= "</table>";
$html .= "</div>";

$conn->close();

echo $html;
?>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#myTable').DataTable({
        paging: true, // Enable pagination
        searching: true, // Enable search functionality
        ordering: true, // Enable ordering (sorting) of columns
        "oLanguage": {
            "sEmptyTable": "No Products Found"
        }
    });

    // Custom function to include all records for the sorted column
    $('#myTable thead').on('click', 'th', function() {
        var columnIndex = table.column($(this)).index();
        var sorting = table.order()[0];
        var sortedColumnIndex = sorting[0];
        var sortOrder = sorting[1];

        if (sortedColumnIndex === columnIndex) {
            // Column is already sorted, include all records
            table.page.len(-1).draw();
        }
    });
});

document.getElementById('addProductBtn').addEventListener('click', function() {
    document.getElementById('productForm').submit();
});
</script>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Input Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="productForm" action="add_product.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="unit">Unit:</label>
            <input type="text" class="form-control" name="unit" id="unit" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="expiry_date">Expiry Date:</label>
            <input type="date" class="form-control" name="expiry_date" id="expiry_date" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="inventory">Available Inventory:</label>
            <input type="number" class="form-control" name="inventory" id="inventory" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="image">Product Image:</label>
            <input id="image" type="file" class="form-control" accept="image/*" name="image" autocomplete="off" required/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="addProductBtn">Add Product</button>
      </div>
    </div>
  </div>
</div>