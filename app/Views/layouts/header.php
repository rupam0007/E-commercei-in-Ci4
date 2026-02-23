<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'ShopCI') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .navbar-brand { font-weight: 700; font-size: 1.5rem; }
        .card { transition: transform .15s; }
        .card:hover { transform: translateY(-3px); box-shadow: 0 6px 18px rgba(0,0,0,.1); }
        .badge-role { font-size: .7rem; }
        footer { background: #212529; color: #adb5bd; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand text-warning" href="<?= base_url('/') ?>">
            <i class="bi bi-bag-heart-fill me-1"></i>ShopCI
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('shop') ?>">Shop</a></li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <?php if (session()->get('logged_in')): ?>
                    <?php if (session()->get('user_role') !== 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('cart') ?>">
                            <i class="bi bi-cart3"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('orders') ?>">Orders</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="<?= base_url('admin/dashboard') ?>">
                            <i class="bi bi-speedometer2"></i> Admin
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= esc(session()->get('user_name') ?? session()->get('user_email')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm ms-1" href="<?= base_url('register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
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
