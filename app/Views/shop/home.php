<?php $title = 'Welcome to ShopCI'; ?>
<?= view('layouts/header') ?>

<!-- Hero Section -->
<div class="rounded-4 bg-dark text-white p-5 mb-5 text-center" style="background: linear-gradient(135deg,#1a1a2e,#0f3460) !important;">
    <h1 class="display-5 fw-bold">Find Your Next Favourite</h1>
    <p class="lead text-white-50">Quality products at unbeatable prices.</p>
    <a href="<?= base_url('shop') ?>" class="btn btn-warning btn-lg fw-bold mt-2">
        <i class="bi bi-bag me-1"></i>Shop Now
    </a>
</div>

<!-- Categories -->
<?php if (!empty($categories)): ?>
<h4 class="fw-bold mb-3">Browse Categories</h4>
<div class="row g-3 mb-5">
    <?php foreach ($categories as $cat): ?>
        <div class="col-6 col-md-3">
            <a href="<?= base_url('shop?category=' . $cat['id']) ?>" class="text-decoration-none">
                <div class="card text-center py-3 border-0 shadow-sm h-100">
                    <div class="fs-2 text-warning"><i class="bi bi-grid-3x3-gap-fill"></i></div>
                    <div class="fw-semibold mt-1"><?= esc($cat['name']) ?></div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Featured Products -->
<h4 class="fw-bold mb-3">Latest Products</h4>
<div class="row g-4">
    <?php if (!empty($featured)): ?>
        <?php foreach ($featured as $product): ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <?php if ($product['image']): ?>
                    <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                         class="card-img-top" style="height:200px;object-fit:cover;" alt="">
                <?php else: ?>
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height:200px;">
                        <i class="bi bi-image text-white fs-1"></i>
                    </div>
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold"><?= esc($product['name']) ?></h6>
                    <p class="text-success fw-bold mb-1">₹<?= number_format($product['price'], 2) ?></p>
                    <div class="mt-auto">
                        <a href="<?= base_url('shop/' . $product['slug']) ?>" class="btn btn-outline-dark btn-sm w-100">
                            View Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center text-muted py-5">
            <i class="bi bi-box-seam fs-1"></i>
            <p class="mt-2">No products yet. Check back soon!</p>
        </div>
    <?php endif; ?>
</div>

<?= view('layouts/footer') ?>
