<?php $title = 'Your Cart'; ?>
<?= view('layouts/header') ?>

<h4 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Your Cart</h4>

<?php if (empty($items)): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-cart-x" style="font-size:4rem;"></i>
        <p class="mt-3 fs-5">Your cart is empty.</p>
        <a href="<?= base_url('shop') ?>" class="btn btn-dark mt-2">Start Shopping</a>
    </div>
<?php else: ?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center" style="width:130px;">Qty</th>
                            <th class="text-center">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if ($item['image']): ?>
                                        <img src="<?= base_url('uploads/products/' . $item['image']) ?>"
                                             width="60" height="60" style="object-fit:cover;" class="rounded">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center"
                                             style="width:60px;height:60px;">
                                            <i class="bi bi-image text-white"></i>
                                        </div>
                                    <?php endif; ?>
                                    <span class="fw-semibold"><?= esc($item['name']) ?></span>
                                </div>
                            </td>
                            <td class="text-center">₹<?= number_format($item['price'], 2) ?></td>
                            <td>
                                <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex gap-1">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>"
                                           min="1" max="<?= $item['stock'] ?>" class="form-control form-control-sm text-center" style="width:65px;">
                                    <button class="btn btn-sm btn-outline-secondary" title="Update">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center fw-bold text-success">
                                ₹<?= number_format($item['price'] * $item['quantity'], 2) ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('cart/remove/' . $item['id']) ?>"
                                   class="btn btn-sm btn-danger" onclick="return confirm('Remove item?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>₹<?= number_format($total, 2) ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span class="text-success">Free</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-success">₹<?= number_format($total, 2) ?></span>
                </div>
                <a href="<?= base_url('checkout') ?>" class="btn btn-dark w-100 mt-4 fw-bold">
                    <i class="bi bi-credit-card me-1"></i>Proceed to Checkout
                </a>
                <a href="<?= base_url('shop') ?>" class="btn btn-outline-secondary w-100 mt-2">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= view('layouts/footer') ?>
