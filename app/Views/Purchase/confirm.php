<?php
$product = $_SESSION['product'];
$buying_count = $_SESSION['buying_count'];
$total = $product['price'] * $buying_count;
$pageTitle = "Product / ".$product['name'];
ob_start();
$image ="data:image/png;base64,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 ";
?>

<style>
    /* Background for the vending machine area */
    .vending-machine-container {
        background: linear-gradient(135deg, #fce4ec, #e3f2fd);
        padding: 2rem;
    }

    /* Card Styling */
    .vending-machine-card {
        border: 2px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        padding: 1.5rem;
        background-color: #fff;
    }

    /* Product Image */
    .product-image {
        width: 50%;
        height: 220px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Product Name and Price */
    .product-name {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
    }

    .product-price {
        font-size: 1.6rem;
        color: #43a047;
        font-weight: bold;
    }

    /* Quantity and Total */
    .product-quantity {
        font-size: 1rem;
        color: #757575;
    }

    .product-total {
        font-size: 1.4rem;
        font-weight: bold;
        color: #ff7043;
        margin: 8px 0;
    }

    /* Total Price */
    .total-price {
        color: #ff5722;
    }

    /* Product Description */
    .product-description {
        font-size: 1rem;
        color: #607d8b;
    }

    /* Button Container */
    .button-container {
        display: flex;
        justify-content: space-around;
        gap: 20px;
    }

    /* Cancel and Confirm Buttons */
    .cancel-button,
    .confirm-button {
        width: 120px;
        font-size: 1.1rem;
        padding: 12px 0;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .cancel-button {
        border-color: #e57373;
        color: #e57373;
    }

    .cancel-button:hover {
        background-color: #e57373;
        color: #fff;
    }

    .confirm-button {
        border-color: #66bb6a;
        color: #66bb6a;
    }

    .confirm-button:hover {
        background-color: #66bb6a;
        color: #fff;
    }
</style>


<div class="d-flex vw-100 vh-100 justify-content-center align-items-center vending-machine-container">
    <div class="card vending-machine-card" style="width: 700px; height: 600px;">
        <div class="card-body text-center">
            <img class="product-image" src="<?php echo $image ?>" alt="Product image">
            <div class="d-flex justify-content-center align-items-center gap-5 mt-4">
                <div class="text-start px-4">
                    <h4 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h4>
                    <h5 class="product-price text-success">$<?php echo number_format($product['price'], 2); ?></h5>
                </div>
                <div class="text-start border-1 border-start px-4">
                    <p class="product-quantity mb-1 text-muted">Quantity: <?php echo htmlspecialchars($buying_count); ?></p>
                    <h5 class="product-total">Total: <span class="total-price">$<?php echo number_format($total, 2); ?></span></h5>
                </div>
            </div>
            <p class="product-description py-3">Enjoy the best of our products at the click of a button.</p>

            <div class="gap-3 d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-outline-danger cancel-button" id="cancel">Cancel</button>
                <button type="button" class="btn btn-outline-success confirm-button" id="confirmed">Confirm</button>
                <button type="button" class="btn btn-outline-primary confirm-button" id="confirm-loading-message" disabled style="display: none;">Loading...</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModalBox" tabindex="-1" role="dialog" aria-labelledby="successModalBoxLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-5 text-center" style="border-radius: 15px; background-color: #ffffff; box-shadow: 0px 0px 30px rgba(0,0,0,0.2);">
                <h2 class="modal-title font-weight-bold text-success mb-3">🎉 Thank you for your purchase! 🎉</h2>
                <hr style="border-top: 2px solid #e0e0e0;">

                <div class="modal-body d-flex flex-column align-items-center">
                    <img src="<?php echo $image; ?>" alt="Product Image" class="img-fluid rounded mb-3" style="width: 400px; height: auto;">

                    <div class="text-start">
                        <p class="mt-4 mb-2" style="font-size: 1.2rem;"><strong>Product:   </strong> <?php echo htmlspecialchars($product['name']); ?></p>
                        <p style="font-size: 1.2rem;"><strong>Quantity:   </strong> <?php echo htmlspecialchars($buying_count); ?></p>
                        <p style="font-size: 1.2rem;"><strong>Total:   </strong> <span class="">$<?php echo number_format($total, 2); ?></span></p>
                    </div>

                    <p class="text-muted mt-4" style="font-size: 1rem;">We hope you enjoy your item! If you have any questions, feel free to reach out to our support team. Safe travels, and see you again soon!</p>
                    <p class="text-primary font-italic" style="font-size: 1.1rem;">🌟 Happy Snacking! 🌟</p>
                </div>

            </div>
        </div>
    </div>

</div>


<?php
$content = ob_get_clean();
include_once __DIR__ . '/../auth/auth.php';
?>
<script>
    $(document).ready(function() {
        $('#cancel').on("click", function() {
            window.location.href = '/';
        });

        const showModal = () => {
            $('#successModalBox').modal({
                backdrop: 'static',
                keyboard: false
            });
        };

        $('.edit-product').on('click', function(e) {
            e.preventDefault();

            const productId = $(this).data('id');
            $('#edit-product-id').val(productId);

            $.get(`/get_edit_product/${productId}`, function(data) {
                if (data.success) {
                    const product = data.product;

                    $('#edit_name').val(product.name);
                    $('#edit_price').val(product.price);
                    $('#edit_quantity').val(product.quantity_available);

                    // Show the modal
                    $('#editProductModal').modal('show');
                } else {
                    alert('Failed to fetch product details.');
                }
            }).fail(function(error) {
                console.error('Error:', error);
            });
        });

        $('#confirmed').on('click', function() {
            const quantity = <?php echo $buying_count; ?>;
            const totalPrice = <?php echo number_format($total, 2); ?>;
            const productId = <?php echo $product['id']; ?>;

            const confirmedLoadingMessage = $('#confirm-loading-message');
            const confirmedButton = $('#confirmed');
            const cancelButton = $('#cancel');
            confirmedButton.hide();
            confirmedLoadingMessage.show();
            cancelButton.prop('disabled', true);

            $.ajax({
                url: '/transaction',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ quantity: quantity, total_price: totalPrice, product_id: productId }),
                success: function(response) {
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    if (response.success) {
                        setTimeout(() => {
                            confirmedLoadingMessage.hide();
                            showModal();
                            setTimeout(() => {
                                $('#successModalBox').modal('hide');
                                window.location.href = "/";
                            }, 3000);
                        }, 1000);
                    } else {
                        confirmedButton.show();
                        confirmedLoadingMessage.hide();
                        $('#successModalBox').modal('hide');
                        cancelButton.prop('disabled', false);
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    confirmedButton.show();
                    confirmedLoadingMessage.hide();
                    cancelButton.prop('disabled', false);
                    $('#successModalBox').modal('hide');
                    console.error('Delete failed:', xhr.responseText);
                    alert('Failed to delete the product. Please try again.');
                }
            });
        });
    });
</script>





