<?php $title = 'Checkout'; ?>
<?= view('layouts/header') ?>

<h4 class="fw-bold mb-4"><i class="bi bi-credit-card me-2"></i>Checkout</h4>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Shipping Form -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3"><i class="bi bi-truck me-1"></i>Shipping Information</h5>
                <form action="<?= base_url('checkout') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_name" class="form-control"
                               value="<?= esc(old('shipping_name', session()->get('user_name'))) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_phone" class="form-control"
                               value="<?= esc(old('shipping_phone')) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Delivery Address <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" rows="3" class="form-control" required
                        ><?= esc(old('shipping_address')) ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Order Notes <span class="text-muted small">(optional)</span></label>
                        <textarea name="notes" rows="2" class="form-control" placeholder="Any special requests..."
                        ><?= esc(old('notes')) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 fw-bold py-2">
                        <i class="bi bi-bag-check me-1"></i>Place Order — ₹<?= number_format($total, 2) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Order Review -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Order Review</h5>
                <?php foreach ($items as $item): ?>
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <div>
                        <span class="fw-semibold"><?= esc($item['name']) ?></span>
                        <small class="text-muted d-block">x<?= $item['quantity'] ?></small>
                    </div>
                    <span class="fw-bold">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </div>
                <?php endforeach; ?>
                <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                    <span>Total</span>
                    <span class="text-success">₹<?= number_format($total, 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/footer') ?>
