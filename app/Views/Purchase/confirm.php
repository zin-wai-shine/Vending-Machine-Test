<?php
$product = $_SESSION['product'];
$buying_count = $_SESSION['buying_count'];
$total = $product['price'] * $buying_count;
$pageTitle = "Product / ".$product['name'];
ob_start();
$image ="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEk1lntksH13oQ2Cf_55ksWMPhi13TXj0y5aNiJz749OKSax5wcAXb1f8l89DaLzYOqoU&usqp=CAU";
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
        width: 40%;
        opacity: 40%;
        object-fit: cover;
        border-radius: 10px;
    }

    .img-fluid{
        width: 70%;
        opacity: 40%;
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





