<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-person-circle me-2"></i>Detail User
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row align-items-center">

                <!-- FOTO -->
                <div class="col-md-3 text-center mb-3">
                    <?php if (!empty($user['foto'])): ?>
                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>"
                            class="img-thumbnail rounded-circle"
                            style="width:150px; height:150px; object-fit:cover;">
                    <?php else: ?>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                            style="width:150px; height:150px;">
                            <i class="bi bi-person fs-1 text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- DATA -->
                <div class="col-md-9">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <strong>Nama</strong><br>
                            <?= esc($user['nama']) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Email</strong><br>
                            <?= esc($user['email']) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Username</strong><br>
                            <?= esc($user['username']) ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Password</strong><br>
                            <span class="text-muted">••••••••</span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <strong>Role</strong><br>

                            <?php if ($user['role'] == 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php elseif ($user['role'] == 'petugas'): ?>
                                <span class="badge bg-warning text-dark">Petugas</span>
                            <?php else: ?>
                                <span class="badge bg-primary">Anggota</span>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- BUTTON -->
    <div class="mt-3 d-flex gap-2">
        <a href="<?= base_url('users') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <?php if (session()->get('role') == 'admin') : ?>
            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        <?php endif; ?>
    </div>

</div>

<?= $this->endSection() ?>