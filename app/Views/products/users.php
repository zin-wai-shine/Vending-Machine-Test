<?php
$pageTitle = 'Transactions';
ob_start();
if (!empty($users)): ?>

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
        <h5 class="">Transaction Lists</h5>
    </div>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $counter = ($page - 1) * $itemsPerPage + 1;
        $counter = 1;// Offset the counter for each page
        foreach ($users as $user): ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <?php
                    echo $user['role'] == 0 ? 'Admin' : 'User';
                    ?>
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



