<?php $title = 'Reports'; ?>
<?= view('admin/layouts/header') ?>

<h5 class="fw-bold mb-4"><i class="bi bi-bar-chart me-1"></i>Reports &amp; Analytics</h5>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-currency-rupee text-success fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Revenue</div>
                    <div class="fw-bold fs-5">₹<?= number_format($totalRevenue, 2) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-receipt text-primary fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Orders</div>
                    <div class="fw-bold fs-5"><?= number_format($totalOrders) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-box-seam text-warning fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Products</div>
                    <div class="fw-bold fs-5"><?= number_format($totalProducts) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 rounded-3 p-3">
                    <i class="bi bi-people text-info fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Customers</div>
                    <div class="fw-bold fs-5"><?= number_format($totalCustomers) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Monthly Revenue -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold border-0 pt-3">
                <i class="bi bi-graph-up me-1 text-success"></i>Monthly Revenue (Last 6 Months)
            </div>
            <div class="card-body">
                <?php if (empty($monthlyRaw)): ?>
                    <p class="text-muted text-center py-4">No order data yet.</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Month</th>
                                <th class="text-center">Orders</th>
                                <th class="text-end">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($monthlyRaw as $row): ?>
                            <tr>
                                <td><?= esc($row['month']) ?></td>
                                <td class="text-center">
                                    <span class="badge bg-primary"><?= $row['count'] ?></span>
                                </td>
                                <td class="text-end fw-bold text-success">₹<?= number_format($row['revenue'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-bold border-0 pt-3">
                <i class="bi bi-trophy me-1 text-warning"></i>Top 5 Products
            </div>
            <div class="card-body p-0">
                <?php if (empty($topProducts)): ?>
                    <p class="text-muted text-center py-4">No sales data yet.</p>
                <?php else: ?>
                <ul class="list-group list-group-flush">
                    <?php foreach ($topProducts as $i => $p): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-dark rounded-circle"><?= $i + 1 ?></span>
                            <span class="small fw-semibold"><?= esc($p['name']) ?></span>
                        </div>
                        <span class="badge bg-success"><?= $p['total_sold'] ?> sold</span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Low Stock -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold border-0 pt-3">
        <i class="bi bi-exclamation-triangle me-1 text-danger"></i>Low Stock Products (≤ 10 units)
    </div>
    <div class="card-body p-0">
        <?php if (empty($lowStock)): ?>
            <p class="text-muted text-center py-4">All products are well stocked.</p>
        <?php else: ?>
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th class="text-center">Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lowStock as $p): ?>
                <tr>
                    <td class="fw-semibold"><?= esc($p['name']) ?></td>
                    <td class="text-center">
                        <span class="badge <?= $p['stock'] == 0 ? 'bg-danger' : 'bg-warning text-dark' ?>">
                            <?= $p['stock'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>"
                           class="btn btn-sm btn-outline-dark">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
