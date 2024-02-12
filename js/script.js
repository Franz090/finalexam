function getImageElementById(id) {
    return document.getElementById(id);
}

function addProduct() {
    var productName = $('#name').val();
    var unit = $('#unit').val();
    var price = $('#price').val();
    var expiryDate = $('#expiry_date').val();
    var inventory = $('#inventory').val();
    var image = $('#image').val();

  
    var nameRegex = /^[A-Za-z\d\s]+$/;
    var unitRegex = /^[A-Za-z\d\s]+$/;
    var priceRegex = /^\d+(\.\d{1,2})?$/; 
    var expiryDateRegex = /^\d{4}-\d{2}-\d{2}$/; 
    var inventoryRegex = /^\d+$/;

    
    if (!productName || !unit || !price || !expiryDate || !inventory || !image) {
        alert("Please fill in all fields.");
        return;
    }

   
    if (!nameRegex.test(productName)) {
        alert("Product name must contain only letters, numbers, or spaces.");
        return;
    }

   
    if (!unitRegex.test(unit)) {
        alert("Unit must contain only letters, numbers, or spaces.");
        return;
    }


    if (!priceRegex.test(price)) {
        alert("Price must be a valid decimal number.");
        return;
    }

   
    if (!expiryDateRegex.test(expiryDate)) {
        alert("Expiry date must be in YYYY-MM-DD format.");
        return;
    }

  
    if (!inventoryRegex.test(inventory)) {
        alert("Available inventory must be a valid integer.");
        return;
    }

   
    var formData = new FormData($('#productForm')[0]);
    
    $.ajax({
        type: 'POST',
        url: 'get_product.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log("Success:", response); 
            location.reload();
            alert("Product successfully added!");
        },
        error: function(error) {
            console.error("Error:", error); 
            alert("Error adding product. Please try again.");
        }
    });
}
function displayProducts() {
    $.ajax({
        type: 'GET',
        url: 'get_product.php',
        success: function(response) {
            $('#productDisplay').html(response);
        }
    });
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
    displayProducts();

    var imageElement = getImageElementById('image');
    if (imageElement) {
        imageElement.addEventListener('change', function (e) {
            const previewImage = getImageElementById('previewImage');
            const fileInput = e.target;
            const file = fileInput.files[0];

            const maxFileSizeMB = 10;

            if (file) {
                if (file.size > maxFileSizeMB * 1024 * 1024) {
                    alert("Error: File is too large. Maximum allowed size is " + maxFileSizeMB + " MB.");
                    fileInput.value = ''; 
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                previewImage.src = '';
                previewImage.style.display = 'none';
            }
        });
    }
});
function deleteProduct(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
        $.ajax({
            type: 'POST',
            url: 'delete_product.php', 
            data: {id: productId}, 
            success: function(response) {
                console.log("Success:", response); 
                displayProducts(); 
                alert("Product successfully deleted!");
            },
            error: function(error) {
                console.error("Error:", error);
                alert("Error deleting product. Please try again.");
            }
        });
    }
}


function updateProduct() {
    var formData = new FormData($('#updateProductForm')[0]);
    var productId = $('#updateId').val(); 
    formData.append('id', productId);
   
    $.ajax({
        type: 'POST',
        url: 'get_product.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log("Success:", response); 
            displayProducts(); 
            populateUpdateForm(formData);
            $('#exampleModal1').modal('hide'); 
            alert("Product successfully updated!");
        },
        error: function(error) {
            console.error("Error:", error);
            alert("Error updating product. Please try again.");
        }
    });
}