<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-person-plus me-2"></i>Tambah User
        </h3>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">

                <div class="row">

                    <!-- NAMA -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Masukkan nama lengkap"
                            required>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            placeholder="contoh@email.com"
                            required>
                    </div>

                    <!-- USERNAME -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text"
                            name="username"
                            class="form-control"
                            placeholder="Masukkan username"
                            required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Masukkan password"
                            required>
                    </div>

                    <!-- ROLE -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="anggota">Anggota</option>
                        </select>
                    </div>

                    <!-- FOTO -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Profil</label>
                        <input type="file"
                            name="foto"
                            class="form-control"
                            accept="image/*">
                        <small class="text-muted">
                            Kosongkan jika tidak upload foto
                        </small>
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>