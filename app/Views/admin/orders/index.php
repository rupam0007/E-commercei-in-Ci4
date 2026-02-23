<?php $title = 'Orders'; ?>
<?= view('admin/layouts/header') ?>

<h5 class="fw-bold mb-4"><i class="bi bi-receipt me-1"></i>All Orders</h5>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Update Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><strong>#<?= $order['id'] ?></strong></td>
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
                    <td>
                        <form action="<?= base_url('admin/orders/status/' . $order['id']) ?>" method="post" class="d-flex gap-1">
                            <?= csrf_field() ?>
                            <select name="status" class="form-select form-select-sm" style="width:130px;">
                                <?php foreach (['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>>
                                        <?= ucfirst($s) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-sm btn-dark" type="submit">
                                <i class="bi bi-check-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($orders)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">No orders yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
