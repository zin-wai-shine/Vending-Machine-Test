<?php
    $pageTitle = "Product / ".$product['name'];
    ob_start();
$image ="data:image/png;base64,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 ";
?>
<!-- HTML structure -->
<div class="d-flex vw-100 vh-100 justify-content-center align-items-center py-5 vending-machine-bg">
    <div class="card vending-machine text-center p-4" style="width: 750px; border-radius: 12px;">
        <div class="product-image-wrapper mb-4">
            <img class="rounded-3" src="<?php echo $image ?>" alt="Product image" style="width: 70%; height: 320px; object-fit: cover; border-radius: 10px;">
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center w-25 ">
                <div>
                    <h6 class="fw-bolder">Quantity Available</h6>
                    <h3 class="text-success mb-0"><?php echo $product['quantity_available'] ?></h3>
                </div>
            </div>
            <h2 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h2>
            <h3 class="product-price" id="price">$<?php echo number_format($product['price'], 2); ?></h3>
            <p class="product-description">An exclusive product you don't want to miss!</p>

            <!-- Quantity Selector -->
            <div class="counter-container d-flex justify-content-center align-items-center gap-3 mt-4">
                <button id="decrement" class="btn decrement-button">-</button>
                <input type="number" class="form-control quantity-input" id="numberInput" value="1" min="1" readonly>
                <button id="increment" class="btn increment-button">+</button>
            </div>

            <!-- Next Button -->
            <div class="next-button-container mt-5">
                <button type="button" class="btn btn-primary next-button" id="next-product">Next</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Background for the vending machine area */
    .vending-machine-bg {
        background: linear-gradient(135deg, #e3f2fd, #fce4ec);
        padding: 2rem;
    }

    /* Vending Machine Card */
    .vending-machine {
        background: #ffffff;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border: none;
    }

    .product-image-wrapper {
        border-radius: 10px;
        overflow: hidden;
    }

    /* Product Details */
    .product-name {
        color: #333;
        font-weight: bold;
        font-size: 1.8rem;
    }

    .product-price {
        color: #00796b;
        font-weight: 600;
        font-size: 1.6rem;
        margin: 8px 0;
    }

    .product-description {
        font-size: 1rem;
        color: #666;
        margin-bottom: 20px;
    }

    /* Counter Container */
    .counter-container .btn {
        width: 50px;
        height: 50px;
        font-size: 24px;
        color: #ffffff;
        background-color: #64b5f6;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .decrement-button:hover,
    .increment-button:hover {
        background-color: #1976d2;
    }

    .quantity-input {
        width: 80px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        background-color: #f1f8e9;
        border: none;
        text-align: center;
    }

    /* Next Button */
    .next-button-container {
        width: 100%;
    }

    .next-button {
        width: 80%;
        font-size: 1.2rem;
        font-weight: bold;
        padding: 15px;
        background-color: #1976d2;
        color: white;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .next-button:hover {
        background-color: #004ba0;
    }
</style>


<?php
$content = ob_get_clean();
include_once __DIR__ . '/../auth/auth.php';
?>
<script>
    $(document).ready(function() {
        let price = <?php echo json_encode($product['price']); ?>;
        $("#price").text("$ " + price);

        const updateButtonState = () => {
            const currentValue = parseInt($("#numberInput").val());
            $("#decrement").prop("disabled", currentValue <= 1);
            $("#increment").prop("disabled", currentValue >= "<?php echo $product['quantity_available']; ?>");
        };

        $("#decrement").on("click", function() {
            let currentValue = parseInt($("#numberInput").val());
            if (currentValue > 1) {
                currentValue -= 1;
                $("#numberInput").val(currentValue);
                $("#price").text("$ " + (price * currentValue).toFixed(2));
                updateButtonState(); // Update button state after decrement
            }
        });

        $("#increment").on("click", function() {
            let currentValue = parseInt($("#numberInput").val());
            if (currentValue < "<?php echo $product['quantity_available']; ?>") {
                currentValue += 1;
                $("#numberInput").val(currentValue);
                console.log('Incremented: ', currentValue);
                $("#price").text("$ " + (price * currentValue).toFixed(2));
                updateButtonState(); // Update button state after increment
            }
        });

        // Initialize button state
        updateButtonState();

        $("#next-product").on("click", function() {
            const numberValue = $("#numberInput").val();
            const productNameSlug = encodeURIComponent('<?php echo htmlspecialchars($product["name"], ENT_QUOTES, "UTF-8"); ?>'.toLowerCase().replace(/\s+/g, '-'));
            $.ajax({
                url: `/product/${productNameSlug}/next`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ buying_count: numberValue }),
                dataType: 'json',
                success: function(data) {
                    window.location.href = `/product/${productNameSlug}/confirmation`;
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>





