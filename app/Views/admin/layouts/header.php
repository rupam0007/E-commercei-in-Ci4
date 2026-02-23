<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — <?= esc($title ?? 'Dashboard') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f1f3f5; }
        .sidebar { width: 240px; min-height: 100vh; background: #1a1a2e; }
        .sidebar .nav-link { color: #adb5bd; border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,.1); color: #fff; }
        .sidebar .nav-link i { width: 22px; }
        .main-content { flex: 1; overflow-x: hidden; }
        .topbar { background: #fff; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column py-3">
        <div class="text-center mb-4 px-3">
            <i class="bi bi-bag-heart-fill text-warning fs-2"></i>
            <div class="text-white fw-bold mt-1">ShopCI Admin</div>
        </div>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= uri_string() === 'admin/dashboard' ? 'active' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/products') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/product') ? 'active' : '' ?>">
                    <i class="bi bi-box-seam me-2"></i>Products
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/categories') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/categor') ? 'active' : '' ?>">
                    <i class="bi bi-grid me-2"></i>Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/orders') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/order') ? 'active' : '' ?>">
                    <i class="bi bi-receipt me-2"></i>Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/customers') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/customer') ? 'active' : '' ?>">
                    <i class="bi bi-people me-2"></i>Customers
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('admin/reports') ?>" class="nav-link <?= str_starts_with(uri_string(), 'admin/report') ? 'active' : '' ?>">
                    <i class="bi bi-bar-chart me-2"></i>Reports
                </a>
            </li>
        </ul>
        <div class="mt-auto px-3 pb-2">
            <a href="<?= base_url('shop') ?>" class="btn btn-outline-secondary btn-sm w-100 mb-1">
                <i class="bi bi-shop me-1"></i>View Shop
            </a>
            <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i>Logout
            </a>
        </div>
    </div>

    <!-- Main -->
    <div class="main-content">
        <div class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><?= esc($title ?? 'Dashboard') ?></h5>
            <span class="text-muted small">
                <i class="bi bi-person-circle me-1"></i><?= esc(session()->get('user_email')) ?>
            </span>
        </div>
        <div class="p-4">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
