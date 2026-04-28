<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Library System</title>

    <!-- Bootstrap CSS Lokal -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg border-0" style="width: 400px; border-radius: 15px;">
            <div class="card-header bg-primary text-white text-center py-4" style="border-radius: 15px 15px 0 0;">
                <!-- Penambahan Icon Buku Besar -->
                <div class="mb-2">
                    <i class="bi bi-book-half" style="font-size: 3rem;"></i>
                </div>
                <h4 class="mb-0 fw-bold">WELCOME BOOKIFY</h4>
                <small>Silakan masuk ke akun Anda</small>
            </div>

            <div class="card-body p-4">

                <!-- Pesan Error -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('salahpw')): ?>
                    <div class="alert alert-danger d-flex align-items-center">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        <?= session()->getFlashdata('salahpw') ?>
                    </div>
                <?php endif; ?>

                <!-- Form Login -->
                <form action="<?= base_url('/proses-login') ?>" method="post">

                    <div class="mb-3">
                        <label class="form-label text-muted">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-person text-primary"></i></span>
                            <input type="text" name="username" class="form-control border-start-0" placeholder="Username" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-key text-primary"></i></span>
                            <input type="password" name="password" class="form-control border-start-0" placeholder="Password" required>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100 py-2 shadow-sm fw-bold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </button>

                </form>

                <hr class="text-muted my-4">

                <!-- Tombol Tambah User -->
                <div class="text-center">
                    <p class="small text-muted mb-3">Belum punya akun atau butuh restore?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="<?= base_url('users/create') ?>" class="btn btn-outline-success btn-sm rounded-pill px-3">
                            <i class="bi bi-person-plus"></i> Daftar Baru
                        </a>
                        <a href="<?= base_url('restore') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                            <i class="bi bi-arrow-clockwise"></i> Restore DB
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>