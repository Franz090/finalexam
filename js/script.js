function getImageElementById(id) {
    return document.getElementById(id);
}

function addProduct() {
    // Perform validation
    var productName = $('#name').val();
    var unit = $('#unit').val();
    var price = $('#price').val();
    var expiryDate = $('#expiry_date').val();
    var inventory = $('#inventory').val();
    var image = $('#image').val();

    // Regular expressions for validation
    var nameRegex = /^[A-Za-z\d\s]+$/;
    var unitRegex = /^[A-Za-z\d\s]+$/;
    var priceRegex = /^\d+(\.\d{1,2})?$/; // Allows decimal numbers with up to 2 decimal places
    var expiryDateRegex = /^\d{4}-\d{2}-\d{2}$/; // Assumes date format in YYYY-MM-DD
    var inventoryRegex = /^\d+$/;

    // Check if any field is empty
    if (!productName || !unit || !price || !expiryDate || !inventory || !image) {
        alert("Please fill in all fields.");
        return;
    }

    // Check if name matches the pattern
    if (!nameRegex.test(productName)) {
        alert("Product name must contain only letters, numbers, or spaces.");
        return;
    }

    // Check if unit matches the pattern
    if (!unitRegex.test(unit)) {
        alert("Unit must contain only letters, numbers, or spaces.");
        return;
    }

    // Check if price matches the pattern
    if (!priceRegex.test(price)) {
        alert("Price must be a valid decimal number.");
        return;
    }

    // Check if expiry date matches the pattern
    if (!expiryDateRegex.test(expiryDate)) {
        alert("Expiry date must be in YYYY-MM-DD format.");
        return;
    }

    // Check if inventory matches the pattern
    if (!inventoryRegex.test(inventory)) {
        alert("Available inventory must be a valid integer.");
        return;
    }

    // Create FormData object
    var formData = new FormData($('#productForm')[0]);
    
    $.ajax({
        type: 'POST',
        url: 'get_product.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log("Success:", response); // Log successful response
            // Reload the page
            location.reload();
            // Show success alert
            alert("Product successfully added!");
        },
        error: function(error) {
            console.error("Error:", error); // Log error response
            // Show error alert
            alert("Error adding product. Please try again.");
        }
    });
}
function displayProducts() {
    $.ajax({
        type: 'GET',
        url: 'get_product.php',
        success: function(response) {
            // Update the product display section with the received data
            $('#productDisplay').html(response);
        }
    });
}

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

  
   
    // Initial product display
    displayProducts();

    // Event listener for file input change
    var imageElement = getImageElementById('image');
    if (imageElement) {
        imageElement.addEventListener('change', function (e) {
            const previewImage = getImageElementById('previewImage');
            const fileInput = e.target;
            const file = fileInput.files[0];

            const maxFileSizeMB = 10; // Maximum file size allowed in MB

            if (file) {
                if (file.size > maxFileSizeMB * 1024 * 1024) {
                    alert("Error: File is too large. Maximum allowed size is " + maxFileSizeMB + " MB.");
                    fileInput.value = ''; // Clear the file input
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