<?php
$pageTitle = 'Vending Machine';
ob_start();

$image ="data:image/png;base64,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 ";
?>

<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background: linear-gradient(135deg, #fce4ec, #e3f2fd);
    }

    .vending-card {
        background-color: #ffffff;
        width: 350px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        text-align: center;
        transition: transform 0.2s ease;
    }

    .vending-card:hover {
        cursor: pointer;
        transform: translateY(-5px);
    }

    .vending-card img {
        width: 80%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .vending-card h2 {
        font-size: 1.5em;
        margin: 10px 0;
        color: #333;
    }

    .vending-card h5 {
        font-size: 1.25em;
        color: #28a745;
        margin: 10px 0;
    }

    .vending-card p {
        font-size: 0.9em;
        color: #666;
        margin: 10px 0 20px;
    }

    .button-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .button {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 1em;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .button:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    .button.secondary {
        background-color: #007bff;
    }

    .button.secondary:hover {
        background-color: #0056b3;
    }

    .product_card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.3); /* Semi-transparent white background */
        backdrop-filter: blur(10px); /* Blur effect */
        border-radius: 8px; /* Optional: rounded corners */
        border: 1px solid rgba(255, 255, 255, 0.5); /* Optional: border for better visibility */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: subtle shadow */
        z-index: 1000; /* Ensure it is above other content */
    }

    .glass-style {
        background: rgba(255, 255, 255, 0.3); /* Semi-transparent white background */
        backdrop-filter: blur(10px); /* Blur effect */
        border-radius: 8px; /* Optional: rounded corners */
        border: 1px solid rgba(255, 255, 255, 0.5); /* Optional: border for better visibility */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: subtle shadow */
    }
</style>

<?php if (!empty($products)): ?>

    <div class="d-flex gap-5 vw-100 vh-100 justify-content-center align-items-center flex-wrap position-relative" style="margin-top: 500px; ">
        <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between align-items-center py-5 position-fixed fixed-top w-100 px-5 glass-effect">
            <a class="navbar-brand fw-bolder text-primary" href="/">Vending Machine</a>
            <button class="btn btn-danger" id="logoutButton">Logout</button>
        </nav>
        <?php foreach ($products as $product): ?>
            <div class="vending-card product_card " data-id="<?php echo $product['id']; ?>">
                <img class="card-img-top" src="<?php echo $image; ?>" alt="Image of <?php echo htmlspecialchars($product['name']); ?>">
                <h4 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h4>
                <h5>$ <?php echo htmlspecialchars($product['price']); ?></h5>
                <p class="card-text">The bulk of the card's content.</p>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php
$content = ob_get_clean();
include_once __DIR__ . '/../auth/auth.php';
?>

<script>
    $(document).ready(function() {
        $('.product_card').on('click', function(e) {
            e.preventDefault();

            const productId = $(this).data('id');

            $.ajax({
                url: `/products/${productId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        const product = data.product;
                        const productNameSlug = encodeURIComponent(product.name.toLowerCase().replace(/\s+/g, '-'));
                        window.location.href = `/product/${productNameSlug}`;
                    } else {
                        alert('Failed to fetch product details.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Failed to fetch product details.');
                }
            });
        });

        $('#logoutButton').on('click', function() {
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
                $.ajax({
                    url: '/logout',
                    method: 'GET',
                    success: function(response) {
                        alert("You have logged out successfully!");
                        window.location.href = '/login';
                    },
                    error: function(xhr, status, error) {
                        alert("Logout failed. Please try again.");
                        console.error("Logout error:", error);
                    }
                });
            } else {
                alert("Logout cancelled.");
            }
        });
    });
</script>

