<?php
$pageTitle = 'Vending Machine';
ob_start();

$image ="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEk1lntksH13oQ2Cf_55ksWMPhi13TXj0y5aNiJz749OKSax5wcAXb1f8l89DaLzYOqoU&usqp=CAU";
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
        width: 60%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
        opacity: 30%;
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

