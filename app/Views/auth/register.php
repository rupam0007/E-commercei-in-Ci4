<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register &mdash; ShopCI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
<div class="card shadow-lg border-0" style="width: 460px;">
    <div class="card-body p-5">
        <div class="text-center mb-4">
            <i class="bi bi-bag-heart-fill text-warning fs-1"></i>
            <h3 class="fw-bold mt-2">Create Account</h3>
            <p class="text-muted">Join ShopCI today</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="John Doe"
                        value="<?= esc(old('name')) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com"
                        value="<?= esc(old('email')) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password <small class="text-muted">(min 6 chars)</small></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn btn-dark w-100 fw-bold">
                <i class="bi bi-person-plus me-1"></i>Create Account
            </button>
        </form>

        <hr class="my-4">
        <p class="text-center text-muted mb-0">
            Already have an account?
            <a href="<?= base_url('login') ?>" class="text-decoration-none fw-semibold">Sign in</a>
        </p>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
