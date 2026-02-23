<?php $title = 'Categories'; ?>
<?= view('admin/layouts/header') ?>

<h5 class="fw-bold mb-4"><i class="bi bi-grid me-1"></i>Categories</h5>

<div class="row g-4">
    <!-- Add Form -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Add Category</h6>
                <form action="<?= base_url('admin/categories') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Category name" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-plus-lg me-1"></i>Add
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- List -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= $cat['id'] ?></td>
                            <td class="fw-semibold"><?= esc($cat['name']) ?></td>
                            <td><code><?= esc($cat['slug']) ?></code></td>
                            <td>
                                <a href="<?= base_url('admin/categories/delete/' . $cat['id']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Delete category?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($categories)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-4">No categories yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
