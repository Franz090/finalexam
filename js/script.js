$(document).ready(function() {
    // Function to add a product using Ajax
    function addProduct() {
        var formData = new FormData($('#productForm')[0]);
        $.ajax({
            type: 'POST',
            url: 'add_product.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
        
                // Reload product display after adding
                displayProducts();
            },
            error: function(error) {
                console.error("Error adding product:", error);
            }
        });
    }

    // Function to display products using Ajax
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

    // Initial product display
    displayProducts();

    // Add product on form submit
    $('#productForm').on('submit', function(e) {
      
        addProduct();
    });
});
document.getElementById('image').addEventListener('change', function (e) {
    const previewImage = document.getElementById('previewImage');
    const fileInput = e.target;
    const file = fileInput.files[0];

    if (file) {
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