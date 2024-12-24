<?php
    $pageTitle = "Product / ".$product['name'];
    ob_start();
$image ="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEk1lntksH13oQ2Cf_55ksWMPhi13TXj0y5aNiJz749OKSax5wcAXb1f8l89DaLzYOqoU&usqp=CAU";
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
    .product-image-wrapper img{
        opacity: 30%;
        width: 50% !important;
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





