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

    // Function to get image element by ID
    function getImageElementById(id) {
        return document.getElementById(id);
    }

    // Initial product display
    displayProducts();

    // Add product on form submit
    $('#productForm').on('submit', function(e) {
        addProduct();
    });

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
