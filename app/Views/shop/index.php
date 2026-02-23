<?php $title = 'Shop'; ?>
<?= view('layouts/header') ?>

<div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><i class="bi bi-funnel me-1"></i>Filter</h6>
                <!-- Search -->
                <form action="<?= base_url('shop') ?>" method="get" class="mb-3">
                    <div class="input-group input-group-sm">
                        <input type="text" name="q" class="form-control" placeholder="Search..."
                               value="<?= esc($search ?? '') ?>">
                        <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                    <?php if (!empty($categoryId)): ?>
                        <input type="hidden" name="category" value="<?= esc($categoryId) ?>">
                    <?php endif; ?>
                </form>

                <hr>
                <h6 class="fw-semibold">Categories</h6>
                <ul class="list-unstyled">
                    <li class="mb-1">
                        <a href="<?= base_url('shop') ?>" class="text-decoration-none <?= empty($categoryId) ? 'fw-bold text-dark' : 'text-muted' ?>">
                            All Products
                        </a>
                    </li>
                    <?php foreach ($categories as $cat): ?>
                    <li class="mb-1">
                        <a href="<?= base_url('shop?category=' . $cat['id']) ?>"
                           class="text-decoration-none <?= $categoryId == $cat['id'] ? 'fw-bold text-dark' : 'text-muted' ?>">
                            <?= esc($cat['name']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">
                <?= !empty($search) ? 'Results for "' . esc($search) . '"' : 'All Products' ?>
            </h5>
            <span class="text-muted small"><?= count($products) ?> item(s)</span>
        </div>

        <div class="row g-4">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                <div class="col-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <?php if ($product['image']): ?>
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                 class="card-img-top" style="height:200px;object-fit:cover;" alt="">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
                                <i class="bi bi-image text-secondary fs-1"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold"><?= esc($product['name']) ?></h6>
                            <p class="text-success fw-bold">₹<?= number_format($product['price'], 2) ?></p>
                            <?php if ($product['stock'] < 1): ?>
                                <span class="badge bg-danger mb-2">Out of Stock</span>
                            <?php elseif ($product['stock'] <= 5): ?>
                                <span class="badge bg-warning text-dark mb-2"><?= $product['stock'] ?> left</span>
                            <?php endif; ?>
                            <div class="mt-auto">
                                <a href="<?= base_url('shop/' . $product['slug']) ?>"
                                   class="btn btn-outline-dark btn-sm w-100">View</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-search fs-1"></i>
                    <p class="mt-2">No products found.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (!empty($pager)): ?>
        <div class="mt-4 d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= view('layouts/footer') ?>
