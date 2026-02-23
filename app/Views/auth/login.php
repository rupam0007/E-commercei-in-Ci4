<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login &mdash; ShopCI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
<div class="card shadow-lg border-0" style="width: 420px;">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <i class="bi bi-bag-heart-fill text-warning fs-1"></i>
            <h3 class="fw-bold mt-2">ShopCI</h3>
            <p class="text-muted">Sign in to your account</p>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= esc($error) ?></div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com"
                        value="<?= esc(old('email')) ?>" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100 fw-bold">
                <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
            </button>
        </form>

        <hr class="my-4">
        <p class="text-center text-muted mb-0">
            Don't have an account?
            <a href="<?= base_url('register') ?>" class="text-decoration-none fw-semibold">Create one</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
