<?php
$isEdit = !empty($product);
$title  = $isEdit ? 'Edit Product' : 'Add Product';
?>
<?= view('admin/layouts/header') ?>

<div class="d-flex align-items-center mb-4 gap-2">
    <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h5 class="fw-bold mb-0"><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h5>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm" style="max-width:720px;">
    <div class="card-body">
        <form action="<?= $isEdit ? base_url('admin/products/update/' . $product['id']) : base_url('admin/products/create') ?>"
              method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="<?= esc(old('name', $product['name'] ?? '')) ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">— No Category —</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= old('category_id', $product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= esc($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" name="price" step="0.01" min="0" class="form-control"
                               value="<?= esc(old('price', $product['price'] ?? '')) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                    <input type="number" name="stock" min="0" class="form-control"
                           value="<?= esc(old('stock', $product['stock'] ?? 0)) ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="4" class="form-control"><?= esc(old('description', $product['description'] ?? '')) ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Product Image</label>
                    <?php if ($isEdit && $product['image']): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                 height="80" class="rounded border">
                            <small class="text-muted ms-2">Current image</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                               <?= old('is_active', $product['is_active'] ?? 1) ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="isActive">Active (visible in shop)</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-dark fw-bold">
                    <i class="bi bi-save me-1"></i><?= $isEdit ? 'Save Changes' : 'Create Product' ?>
                </button>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
