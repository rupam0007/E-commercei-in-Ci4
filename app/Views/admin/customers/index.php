<?php $title = 'Customers'; ?>
<?= view('admin/layouts/header') ?>

<h5 class="fw-bold mb-4"><i class="bi bi-people me-1"></i>Customers</h5>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center">Orders</th>
                    <th class="text-end">Total Spent</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">No customers found.</td>
                </tr>
                <?php else: ?>
                <?php foreach ($customers as $c): ?>
                <tr>
                    <td class="text-muted small"><?= $c['id'] ?></td>
                    <td class="fw-semibold"><?= esc($c['name']) ?></td>
                    <td class="text-muted"><?= esc($c['email']) ?></td>
                    <td class="text-center">
                        <span class="badge bg-secondary"><?= $c['order_count'] ?></span>
                    </td>
                    <td class="text-end fw-bold text-success">₹<?= number_format($c['total_spent'], 2) ?></td>
                    <td class="text-muted small"><?= date('M j, Y', strtotime($c['created_at'])) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
