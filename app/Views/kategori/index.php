<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-tags me-2"></i>Data Kategori
            </h3>
            <small class="text-muted">
                Kelola daftar kategori buku
            </small>
        </div>

        <!-- Tombol Tambah -->
        <a href="<?= base_url('kategori/create') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>Tambah Kategori
        </a>

    </div>

    <!-- CARD TABLE -->
    <div class="card shadow-sm border-0">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-success text-center">
                        <tr>
                            <th width="80">ID</th>
                            <th class="text-start">Nama Kategori</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($kategori)): ?>
                            <?php foreach ($kategori as $k): ?>
                                <tr>

                                    <td class="text-center fw-semibold">
                                        <?= $k['id_kategori'] ?>
                                    </td>

                                    <td>
                                        <?= $k['nama_kategori'] ?>
                                    </td>

                                    <td class="text-center">

                                        <a href="<?= base_url('kategori/edit/' . $k['id_kategori']) ?>"
                                            class="btn btn-sm btn-warning text-dark">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        <a href="<?= base_url('kategori/delete/' . $k['id_kategori']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin mau hapus kategori ini?')">
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </a>

                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>

                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada data kategori
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<style>
    .card {
        border-radius: 14px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .btn {
        border-radius: 8px;
    }
</style>

<?= $this->endSection() ?>