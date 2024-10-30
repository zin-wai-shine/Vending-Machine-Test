<?php
$pageTitle = 'All Products';
ob_start();
if (!empty($products)): ?>

    <div class="modal fade" id="createNewProductModal" tabindex="-1" role="dialog" aria-labelledby="createNewProductModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h6 class="modal-title" id="exampleModalLongTitle">Add new product</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form class="d-flex flex-column justify-content-center gap-4 mb-1" id="add-new-product">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control mt-2" id="name">
                            <div class="text-danger mt-1" id="name-error" style="display: none;"></div> <!-- Error message placeholder -->
                        </div>
                        <div class="d-flex justify-content-between align-items-center gap-4">
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control mt-2" id="price">
                                <div class="text-danger mt-1" id="price-error" style="display: none;"></div> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control mt-2" id="quantity">
                                <div class="text-danger mt-1" id="quantity-error" style="display: none;"></div> <!-- Error message placeholder -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary bg-primary" id="loading-message" disabled style="display: none;">Loading...</button>
                    <button type="button" class="btn btn-primary" id="save-product">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h6 class="modal-title" id="exampleModalLongTitle">Add new product</h6>
                    <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <form class="d-flex flex-column justify-content-center gap-4 mb-1" id="edit-product-form">
                        <input type="number" id="edit-product-id" value="" hidden="hidden">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" class="form-control mt-2" id="edit_name">
                            <div class="text-danger mt-1" id="edit-name-error" style="display: none;"></div> <!-- Error message placeholder -->
                        </div>
                        <div class="d-flex justify-content-between align-items-center gap-4">
                            <div class="form-group">
                                <label for="edit_price">Price</label>
                                <input type="number" class="form-control mt-2" id="edit_price">
                                <div class="text-danger mt-1" id="edit-price-error" style="display: none;"></div> <!-- Error message placeholder -->
                            </div>
                            <div class="form-group">
                                <label for="edit_quantity">Quantity</label>
                                <input type="number" class="form-control mt-2" id="edit_quantity">
                                <div class="text-danger mt-1" id="edit-quantity-error" style="display: none;"></div> <!-- Error message placeholder -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary bg-primary" id="edit-loading-message" disabled style="display: none;">loading...</button>
                    <button type="button" class="btn btn-primary" id="update-product">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Product Lists</h5>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createNewProductModal">
            Add new product
        </button>
    </div>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $counter = ($page - 1) * $itemsPerPage + 1;
            $counter = 1;// Offset the counter for each page
        foreach ($products as $product): ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td>$ <?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity_available']); ?></td>
                <td>
                    <button class="btn btn-warning edit-product" data-id="<?php echo $product['id']; ?>">Edit</button>
                    <form id="delete-form-<?php echo $product['id']; ?>" style="display:inline;">
                        <button type="button" class="btn btn-danger delete-product" data-id="<?php echo $product['id']; ?>">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
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

<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
<?php
    $content = ob_get_clean();
    include_once __DIR__ . '/../layout/app.php';
?>
<script>
    document.getElementById('save-product').addEventListener('click', function () {
        const name = document.getElementById('name').value.trim();
        const price = document.getElementById('price').value.trim();
        const quantity = document.getElementById('quantity').value.trim();

        // Clear previous error messages
        document.getElementById('name-error').style.display = 'none';
        document.getElementById('price-error').style.display = 'none';
        document.getElementById('quantity-error').style.display = 'none';

        const loadingMessage = document.getElementById('loading-message');
        const saveProduct = document.getElementById('save-product');
        saveProduct.style.display = "none";
        loadingMessage.style.display = 'block';

        fetch('/add_new_product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, price, quantity })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setTimeout(() => {
                        loadingMessage.style.display = 'none';
                        location.reload();
                    }, 1000)
                } else {
                    saveProduct.style.display = "block";
                    loadingMessage.style.display = 'none';
                        if (data.errors) {
                            if (data.errors.name) {
                                document.getElementById('name-error').textContent = data.errors.name;
                                document.getElementById('name-error').style.display = 'block';
                            }
                            if (data.errors.price) {
                                document.getElementById('price-error').textContent = data.errors.price;
                                document.getElementById('price-error').style.display = 'block';
                            }
                            if (data.errors.quantity) {
                                document.getElementById('quantity-error').textContent = data.errors.quantity;
                                document.getElementById('quantity-error').style.display = 'block';
                            }
                        } else {
                            setTimeout(() => {
                                loadingMessage.style.display = 'none';
                            }, 1000)
                        }
                    ;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingMessage.style.display = 'none';
            });
    });

    document.querySelectorAll('.edit-product').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const productId = this.getAttribute('data-id');
            $('#edit-product-id').val(productId)

            fetch(`/get_edit_product/${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const product = data.product;

                        document.getElementById('edit_name').value = product.name;
                        document.getElementById('edit_price').value = product.price;
                        document.getElementById('edit_quantity').value = product.quantity_available;

                        // Show the modal
                        $('#editProductModal').modal('show');
                    } else {
                        alert('Failed to fetch product details.');
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    $(document).ready(function() {
        $('#update-product').on('click', function() {
            const formData = new FormData();

            // Get values from the form
            const productId = $('#edit-product-id').val();
            const productName = $('#edit_name').val();
            const productPrice = $('#edit_price').val();
            const productQuantity = $('#edit_quantity').val();

            formData.append('id', productId);
            formData.append('name', productName);
            formData.append('price', productPrice);
            formData.append('quantity', productQuantity);

            const editLoadingMessage = document.getElementById('edit-loading-message');
            const updateProduct = document.getElementById('update-product')
            updateProduct.style.display = "none";
            editLoadingMessage.style.display = 'block';

            $.ajax({
                url: '/update_product',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    if (response.success) {
                        setTimeout(() => {
                            editLoadingMessage.style.display = "none";
                            $('#edit-product-form')[0].reset();
                            $('#editProductModal').modal('hide');
                            location.reload();
                        }, 1000)
                    } else {
                        updateProduct.style.display = "block";
                        editLoadingMessage.style.display = 'none';
                        if (response.errors) {

                            if (response.errors.name) {
                                document.getElementById('edit-name-error').textContent = response.errors.name;
                                document.getElementById('edit-name-error').style.display = 'block';
                            }
                            if (response.errors.price) {
                                document.getElementById('edit-price-error').textContent = response.errors.price;
                                document.getElementById('edit-price-error').style.display = 'block';
                            }
                            if (response.errors.quantity) {
                                document.getElementById('edit-quantity-error').textContent = response.errors.quantity;
                                document.getElementById('edit-quantity-error').style.display = 'block';
                            }
                        } else {
                            setTimeout(() => {
                                document.getElementById('editLoadingMessage').style.display = 'none';
                            }, 1000)
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Update failed:', xhr.responseText);
                    alert('Failed to update the product. Please try again.');
                }
            });
        });
    });

    $(document).ready(function() {
        $('.delete-product').on('click', function() {
            const productId = $(this).data('id');
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: '/delete_product',
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({ productId: productId }),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Delete failed:', xhr.responseText);
                        alert('Failed to delete the product. Please try again.');
                    }
                });
            }
        });
    });


</script>



