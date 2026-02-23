<?php $title = esc($product['name']); ?>
<?= view('layouts/header') ?>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('shop') ?>">Shop</a></li>
        <li class="breadcrumb-item active"><?= esc($product['name']) ?></li>
    </ol>
</nav>

<div class="row g-5">
    <!-- Image -->
    <div class="col-md-5">
        <?php if ($product['image']): ?>
            <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                 class="img-fluid rounded-3 shadow" alt="<?= esc($product['name']) ?>">
        <?php else: ?>
            <div class="bg-secondary rounded-3 d-flex align-items-center justify-content-center" style="height:380px;">
                <i class="bi bi-image text-white" style="font-size:5rem;"></i>
            </div>
        <?php endif; ?>
    </div>

    <!-- Details -->
    <div class="col-md-7">
        <?php if (!empty($product['category_name'])): ?>
            <span class="badge bg-secondary mb-2"><?= esc($product['category_name']) ?></span>
        <?php endif; ?>
        <h2 class="fw-bold"><?= esc($product['name']) ?></h2>
        <h3 class="text-success fw-bold my-3">₹<?= number_format($product['price'], 2) ?></h3>

        <?php if ($product['stock'] > 0): ?>
            <span class="badge bg-success mb-3">
                <i class="bi bi-check-circle me-1"></i>In Stock (<?= $product['stock'] ?> available)
            </span>
        <?php else: ?>
            <span class="badge bg-danger mb-3">Out of Stock</span>
        <?php endif; ?>

        <?php if (!empty($product['description'])): ?>
            <p class="text-muted"><?= nl2br(esc((string) $product['description'])) ?></p>
        <?php endif; ?>

        <?php if ($product['stock'] > 0 && session()->get('logged_in')): ?>
        <form action="<?= base_url('cart/add') ?>" method="post" class="d-flex gap-2 align-items-center mt-3">
            <?= csrf_field() ?>
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="input-group" style="max-width:130px;">
                <span class="input-group-text">Qty</span>
                <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control">
            </div>
            <button type="submit" class="btn btn-dark fw-bold">
                <i class="bi bi-cart-plus me-1"></i>Add to Cart
            </button>
        </form>
        <?php elseif (!session()->get('logged_in')): ?>
            <a href="<?= base_url('login') ?>" class="btn btn-outline-dark mt-3">
                <i class="bi bi-box-arrow-in-right me-1"></i>Login to Buy
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Related Products -->
<?php if (!empty($related)): ?>
<hr class="my-5">
<h5 class="fw-bold mb-3">Related Products</h5>
<div class="row g-4">
    <?php foreach ($related as $r): ?>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <?php if ($r['image']): ?>
                <img src="<?= base_url('uploads/products/' . $r['image']) ?>"
                     class="card-img-top" style="height:160px;object-fit:cover;" alt="">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px;">
                    <i class="bi bi-image text-secondary fs-2"></i>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <h6 class="fw-semibold"><?= esc($r['name']) ?></h6>
                <p class="text-success fw-bold mb-2">₹<?= number_format($r['price'], 2) ?></p>
                <a href="<?= base_url('shop/' . $r['slug']) ?>" class="btn btn-outline-dark btn-sm w-100">View</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?= view('layouts/footer') ?>
