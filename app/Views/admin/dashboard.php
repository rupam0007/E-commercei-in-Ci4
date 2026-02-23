<?php $title = 'Dashboard'; ?>
<?= view('admin/layouts/header') ?>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-1 text-primary"><i class="bi bi-box-seam"></i></div>
            <div class="fs-2 fw-bold"><?= $stats['total_products'] ?></div>
            <div class="text-muted">Products</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-1 text-success"><i class="bi bi-receipt"></i></div>
            <div class="fs-2 fw-bold"><?= $stats['total_orders'] ?></div>
            <div class="text-muted">Total Orders</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-1 text-warning"><i class="bi bi-clock-history"></i></div>
            <div class="fs-2 fw-bold"><?= $stats['pending_orders'] ?></div>
            <div class="text-muted">Pending Orders</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-1 text-info"><i class="bi bi-people"></i></div>
            <div class="fs-2 fw-bold"><?= $stats['total_users'] ?></div>
            <div class="text-muted">Customers</div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span class="fw-bold"><i class="bi bi-receipt me-1"></i>Recent Orders</span>
        <a href="<?= base_url('admin/orders') ?>" class="btn btn-sm btn-outline-light">View All</a>
    </div>
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($stats['recent_orders'], 0, 10) as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td>
                        <div class="fw-semibold"><?= esc($order['customer_name']) ?></div>
                        <small class="text-muted"><?= esc($order['customer_email']) ?></small>
                    </td>
                    <td class="fw-bold text-success">₹<?= number_format($order['total_amount'], 2) ?></td>
                    <td>
                        <?php
                        $badges = ['pending'=>'warning','processing'=>'info','shipped'=>'primary','delivered'=>'success','cancelled'=>'danger'];
                        $b = $badges[$order['status']] ?? 'secondary';
                        ?>
                        <span class="badge bg-<?= $b ?>"><?= ucfirst($order['status']) ?></span>
                    </td>
                    <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($stats['recent_orders'])): ?>
                    <tr><td colspan="5" class="text-center text-muted py-4">No orders yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
