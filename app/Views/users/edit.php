<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit User
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">

                <div class="row">

                    <!-- NAMA -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text"
                            name="nama"
                            class="form-control"
                            value="<?= esc($user['nama']) ?>"
                            required>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email"
                            name="email"
                            class="form-control"
                            value="<?= esc($user['email']) ?>"
                            required>
                    </div>

                    <!-- USERNAME -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text"
                            name="username"
                            class="form-control"
                            value="<?= esc($user['username']) ?>"
                            required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">
                            Password
                            <small class="text-muted">(kosongkan jika tidak diubah)</small>
                        </label>
                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Isi jika ingin mengganti password">
                    </div>

                    <!-- ROLE -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select">

                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>
                                Admin
                            </option>

                            <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>
                                Petugas
                            </option>

                            <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>
                                Anggota
                            </option>

                        </select>
                    </div>

                    <!-- FOTO -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Foto Profil</label>
                        <input type="file"
                            name="foto"
                            class="form-control">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti foto
                        </small>

                        <div class="mt-2">
                            <p class="mb-1">Foto sekarang:</p>

                            <?php if (!empty($user['foto'])): ?>
                                <img src="<?= base_url('uploads/users/' . $user['foto']) ?>"
                                    class="img-thumbnail"
                                    style="width:100px; height:100px; object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted">Tidak ada foto</span>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
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