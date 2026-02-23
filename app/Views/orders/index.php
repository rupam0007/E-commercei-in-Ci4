<?php $title = 'My Orders'; ?>
<?= view('layouts/header') ?>

<h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2"></i>My Orders</h4>

<?php if (empty($orders)): ?>
    <div class="text-center py-5 text-muted">
        <i class="bi bi-bag-x" style="font-size:4rem;"></i>
        <p class="mt-3 fs-5">You haven't placed any orders yet.</p>
        <a href="<?= base_url('shop') ?>" class="btn btn-dark mt-2">Start Shopping</a>
    </div>
<?php else: ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Shipping To</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong>#<?= $order['id'] ?></strong></td>
                        <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                        <td class="fw-bold text-success">₹<?= number_format($order['total_amount'], 2) ?></td>
                        <td>
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
                            <span class="badge bg-<?= $badge ?> text-<?= $badge === 'warning' ? 'dark' : 'white' ?>">
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </td>
                        <td><?= esc($order['shipping_name']) ?></td>
                        <td>
                            <a href="<?= base_url('orders/' . $order['id']) ?>" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-eye me-1"></i>View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= view('layouts/footer') ?>
