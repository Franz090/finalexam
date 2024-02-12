<?php
include_once('./connections/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $name = $_POST['name'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $inventory = $_POST['inventory'];

   
    if (empty($price) || !is_numeric($price)) {
        return;
    }

   
    if (!empty($_FILES["image"]["name"])) {

    $targetDir = "uploads/";
    $image = $targetDir . basename($_FILES["image"]["name"]);
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

   
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $uploadOk = 0;
    }

    $maxFileSize = 10 * 1024 * 1024; 

   
    if ($_FILES["image"]["size"] > $maxFileSize) {
        $uploadOk = 0;
    }

   
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        $uploadOk = 0;
    }

   
    if ($uploadOk == 1) {
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
           
            $sql = "INSERT INTO products (name, unit, price, expiry_date, inventory, image) 
                    VALUES ('$name', '$unit', '$price', '$expiry_date', '$inventory', '$image')";

            $result = $conn->query($sql);

            if ($result !== TRUE) {
               
            }
        }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateName"])) {
   
    $id = $_POST['updateId']; 
    $name = $_POST['updateName'];
    $unit = $_POST['updateUnit'];
    $price = $_POST['updatePrice'];
    $expiry_date = $_POST['updateExpiryDate'];
    $inventory = $_POST['updateInventory'];
    

   
    if (empty($price) || !is_numeric($price)) {
        return;
    }

    if (!empty($_FILES["updateImage"]["name"])) {
      $targetDir = "uploads/";
      $image = $targetDir . basename($_FILES["updateImage"]["name"]);
  } else {
      
      $image = ''; 
  }
  

  $sql = "UPDATE products 
  SET name='$name', unit='$unit', price='$price', expiry_date='$expiry_date', inventory='$inventory'";

if (!empty($image)) {
$sql .= ", image='$image'";
}
$sql .= " WHERE id='$id'";

            

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error updating product: " . $conn->error;
    }
}


$sql = "SELECT * FROM products";
$result = $conn->query($sql);

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
$html .= "<th>Action</th>";
$html .= "</tr>";
$html .= "</thead>";
$html .= "<tbody>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= "<tr>";
        $html .= "<td>" . $row['name'] . "</td>";
        $html .= "<td>" . $row['unit'] . "</td>";
        $html .= "<td>$" . $row['price'] . "</td>";
        $formatted_date = date("F j, Y", strtotime($row['expiry_date']));
        $html .= "<td>" . $formatted_date . "</td>";
        $html .= "<td>" . $row['inventory'] . "</td>";
        $html .= "<td>$" . ($row['inventory'] * $row['price']) . "</td>";
        $html .= "<td><img src='" . $row['image'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
        $html .= "<td>";
        $html .= "<div class='text-center'>";
        $html .= "<button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#exampleModal1' data-bs-whatever='@mdo' onclick='populateUpdateForm(" . json_encode($row) . ")'>Update</button>";
        $html .= "<button class='btn-danger btn' onclick='deleteProduct(" . $row['id'] . ")'>Delete</button>";
        $html .= "</div>";
        $html .= "</td>";
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
  function populateUpdateForm(productData) {
    $('#updateId').val(productData.id); 
    $('#updateName').val(productData.name);
    $('#updateUnit').val(productData.unit);
    $('#updatePrice').val(productData.price);
    $('#updateExpiryDate').val(productData.expiry_date);
    $('#updateInventory').val(productData.inventory);
    $('#updateImage').html('<img src="' + productData.image + '" alt="Product Image" style="max-width: 100px; max-height: 100px;">');
 
}
$(document).ready(function() {
    var table = $('#myTable').DataTable({
        paging: true, 
        searching: true,
        ordering: true, 
        "oLanguage": {
            "sEmptyTable": "No Products Found"
        }
    });
    $('#myTable thead').on('click', 'th', function() {
        var columnIndex = table.column($(this)).index();
        var sorting = table.order()[0];
        var sortedColumnIndex = sorting[0];
        var sortOrder = sorting[1];

        if (sortedColumnIndex === columnIndex) {
            table.page.len(-1).draw();
        }
    });
});

    
     $('#addProductBtn').on('click', function(e) {
        addProduct();
    });
    $('#updateProductBtn').on('click', function(e) {
        e.preventDefault(); 
        updateProduct();
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
        <form id="productForm" method="post" enctype="multipart/form-data">
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

<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateProductForm" method="post" enctype="multipart/form-data">
        <div class="form-group">
   
    <input type="hidden" class="form-control" name="updateId" id="updateId" autocomplete="off" required>
</div>
          <div class="form-group">
            <label for="updateName">Product Name:</label>
            <input type="text" class="form-control" name="updateName" id="updateName" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="updateUnit">Unit:</label>
            <input type="text" class="form-control" name="updateUnit" id="updateUnit" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="updatePrice">Price:</label>
            <input type="number" step="0.01" class="form-control" name="updatePrice" id="updatePrice" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="updateExpiryDate">Expiry Date:</label>
            <input type="date" class="form-control" name="updateExpiryDate" id="updateExpiryDate" autocomplete="off" required>
          </div>
          
          <div class="form-group">
            <label for="updateInventory">Available Inventory:</label>
            <input type="number" class="form-control" name="updateInventory" id="updateInventory" autocomplete="off" required>
          </div>
          
  
          
          <div class="form-group">
            <label for="updateImage">Product Image:</label>
            <input id="updateImage" type="file" class="form-control" accept="image/*" name="updateImage" autocomplete="off"/>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
      </div>
    </div>
  </div>
</div>