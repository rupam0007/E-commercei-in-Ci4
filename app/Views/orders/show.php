<?php $title = 'Order #' . $order['id']; ?>
<?= view('layouts/header') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-receipt me-2"></i>Order #<?= $order['id'] ?></h4>
    <a href="<?= base_url('orders') ?>" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Back to Orders
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white fw-bold">Order Items</div>
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <?php if ($item['image']): ?>
                                        <img src="<?= base_url('uploads/products/' . $item['image']) ?>"
                                             width="50" height="50" style="object-fit:cover;" class="rounded">
                                    <?php endif; ?>
                                    <?= esc($item['name']) ?>
                                </div>
                            </td>
                            <td class="text-center">₹<?= number_format($item['price'], 2) ?></td>
                            <td class="text-center"><?= $item['quantity'] ?></td>
                            <td class="text-center fw-bold">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr class="table-light">
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="text-center fw-bold text-success fs-5">
                                ₹<?= number_format($order['total_amount'], 2) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-dark text-white fw-bold">Order Status</div>
            <div class="card-body">
                <?php
                $badges = [
                    'pending'    => 'warning',
                    'processing' => 'info',
                    'shipped'    => 'primary',
                    'delivered'  => 'success',
                    'cancelled'  => 'danger',
                ];
                $badge = $badges[$order['status']] ?? 'secondary';
                ?>
                <span class="badge bg-<?= $badge ?> fs-6">
                    <?= ucfirst($order['status']) ?>
                </span>
                <p class="text-muted mt-2 mb-0 small">
                    Ordered on <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                </p>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">Shipping Details</div>
            <div class="card-body">
                <p class="mb-1"><strong><?= esc($order['shipping_name']) ?></strong></p>
                <p class="mb-1 text-muted"><?= esc($order['shipping_phone']) ?></p>
                <p class="mb-0 text-muted"><?= nl2br(esc((string) $order['shipping_address'])) ?></p>
                <?php if ($order['notes']): ?>
                    <hr>
                    <p class="mb-0 small text-muted"><em><?= nl2br(esc((string) $order['notes'])) ?></em></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= view('layouts/footer') ?>
