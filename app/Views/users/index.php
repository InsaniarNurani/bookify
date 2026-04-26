<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-people me-2"></i>Data Users
        </h3>

        <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Tambah
        </a>
    </div>

    <!-- FILTER -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">

            <form method="get" class="row g-2">

                <div class="col-md-4">
                    <input type="text"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari nama..."
                        value="<?= esc($_GET['keyword'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">-- Semua Role --</option>
                        <option value="admin" <?= (($_GET['role'] ?? '') == 'admin') ? 'selected' : '' ?>>Admin</option>
                        <option value="petugas" <?= (($_GET['role'] ?? '') == 'petugas') ? 'selected' : '' ?>>Petugas</option>
                        <option value="anggota" <?= (($_GET['role'] ?? '') == 'anggota') ? 'selected' : '' ?>>Anggota</option>
                    </select>
                </div>

                <div class="col-md-5 d-flex gap-2">
                    <button class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>

                    <a href="<?= base_url('users') ?>" class="btn btn-secondary">
                        Reset
                    </a>

                    <a href="<?= base_url('users/print?' . http_build_query($_GET)) ?>"
                        target="_blank"
                        class="btn btn-success">
                        <i class="bi bi-printer"></i>
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- TABLE -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Foto</th>
                            <?php if (session()->get('role') == 'admin') : ?>
                                <th width="220">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = 1 + (10 * ($pager->getCurrentPage() - 1)); ?>

                            <?php foreach ($users as $u): ?>
                                <tr>

                                    <!-- NO -->
                                    <td class="text-center"><?= $no++ ?></td>

                                    <!-- NAMA -->
                                    <td class="fw-semibold">
                                        <?= esc($u['nama']) ?>
                                    </td>

                                    <!-- EMAIL -->
                                    <td><?= esc($u['email']) ?></td>

                                    <!-- USERNAME -->
                                    <td><?= esc($u['username']) ?></td>

                                    <!-- ROLE -->
                                    <td class="text-center">
                                        <?php if ($u['role'] == 'admin'): ?>
                                            <span class="badge bg-danger">Admin</span>
                                        <?php elseif ($u['role'] == 'petugas'): ?>
                                            <span class="badge bg-warning text-dark">Petugas</span>
                                        <?php else: ?>
                                            <span class="badge bg-primary">Anggota</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- FOTO -->
                                    <td class="text-center">
                                        <?php if (!empty($u['foto'])): ?>
                                            <img src="<?= base_url('uploads/users/' . $u['foto']) ?>"
                                                class="rounded-circle"
                                                style="width:50px; height:50px; object-fit:cover;">
                                        <?php else: ?>
                                            <i class="bi bi-person-circle fs-3 text-muted"></i>
                                        <?php endif; ?>
                                    </td>

                                    <!-- AKSI -->
                                    <?php if (session()->get('role') == 'admin') : ?>
                                        <td>
                                            <div class="d-flex gap-1 flex-wrap">

                                                <a href="<?= base_url('users/detail/' . $u['id']) ?>"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <a href="<?= base_url('users/edit/' . $u['id']) ?>"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <a href="<?= base_url('users/wa/' . $u['id']) ?>"
                                                    target="_blank"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>

                                                <a href="<?= base_url('users/delete/' . $u['id']) ?>"
                                                    onclick="return confirm('Hapus user ini?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </a>

                                            </div>
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada data user
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-3">
                <?= $pager->links() ?>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>