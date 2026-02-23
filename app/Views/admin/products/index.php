<?php $title = 'Products'; ?>
<?= view('admin/layouts/header') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-1"></i>Products</h5>
    <a href="<?= base_url('admin/products/create') ?>" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i>Add Product
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if ($product['image']): ?>
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                 width="50" height="50" class="rounded" style="object-fit:cover;">
                        <?php else: ?>
                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                <i class="bi bi-image text-white small"></i>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td class="fw-semibold"><?= esc($product['name']) ?></td>
                    <td><?= esc($product['category_name'] ?? '—') ?></td>
                    <td class="text-success fw-bold">₹<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <?php if ($product['stock'] < 1): ?>
                            <span class="badge bg-danger">0</span>
                        <?php elseif ($product['stock'] <= 5): ?>
                            <span class="badge bg-warning text-dark"><?= $product['stock'] ?></span>
                        <?php else: ?>
                            <span class="badge bg-success"><?= $product['stock'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge bg-<?= $product['is_active'] ? 'success' : 'secondary' ?>">
                            <?= $product['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?= base_url('admin/products/edit/' . $product['id']) ?>"
                               class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <a href="<?= base_url('admin/products/delete/' . $product['id']) ?>"
                               class="btn btn-outline-danger"
                               onclick="return confirm('Delete this product?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">No products yet. <a href="<?= base_url('admin/products/create') ?>">Add one</a></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
