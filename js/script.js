$(document).ready(function() {
    // Function to add product using Ajax
    function addProduct() {
        var formData = new FormData($('#productForm')[0]);
        $.ajax({
            type: 'POST',
            url: 'add_product.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Reload product display after adding
                displayProducts();
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
});
