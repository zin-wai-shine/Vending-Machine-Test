<?php
    $pageTitle = 'Transactions';
    ob_start();
?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="">Transaction Lists</h5>
        <?php if (isset($_SESSION['selected_product_id'])): // Check if session variable exists ?>
            <div class="d-flex justify-content-center align-items-center gap-5">
                <span class="mb-0 text-primary">Soft For: <?php echo $_SESSION['selected_product_name'] ?></span>
                <button class="btn btn-sm btn-primary" id="all_transactions">Click for all transactions</button>
            </div>
        <?php endif; ?>

        <select class="form-select w-25" id="product-soft-select" aria-label="Sort by product">
            <option selected>Sort by product</option>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo htmlspecialchars($product['id']); ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
        </tr>
        </thead>
        <?php if (!empty($transactions)): ?>

            <tbody>
            <?php
            $counter = ($page - 1) * $itemsPerPage + 1;
            $counter = 1;// Offset the counter for each page
            foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo $counter++; ?></td>
                    <td><?php echo htmlspecialchars($transaction['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                    <td><?php echo htmlspecialchars($transaction['total_price']); ?></td>
                </tr>
        <?php endforeach; ?>
        </tbody>
        <?php else: ?>
        <tbody>
            <tr aria-colspan="5" class="text-center">
                <td colspan="5" class="text-center">
                    Product not found.
                </td>
            </tr>
        </tbody>
<?php endif; ?>

    </table>

    <div class="d-flex justify-content-between align-items-center">
        <h6>Total: (<?php echo $totalItems ?>)</h6>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <div>

        </div>

    </div>




<?php
    $content = ob_get_clean();
include_once __DIR__ . '/../layout/app.php';
?>
<script>
    $(document).ready(function() {
        $('#all_transactions').click(function() {
            console.log('All Transactions button clicked');
            $.ajax({
                url: '/transactions',
                type: 'GET',
                data: {
                    clear_filter: true
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#product-soft-select').change(function() {
            var selectedProductId = $(this).val();
            var selectedProductName = $(this).find("option:selected").text();
            console.log('Product selected:', selectedProductId, selectedProductName);
            $.ajax({
                url: `/transactions`,
                type: 'GET',
                data: {
                    product_id: selectedProductId,
                    product_name: selectedProductName
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>



