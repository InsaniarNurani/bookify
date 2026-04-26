<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-building me-2"></i>Data Penerbit
        </h3>

        <a href="<?= base_url('penerbit/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th width="80">ID</th>
                            <th>Nama Penerbit</th>
                            <th>Alamat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($penerbit)): ?>
                            <?php foreach ($penerbit as $p): ?>
                                <tr>

                                    <td class="text-center">
                                        <?= $p['id_penerbit'] ?>
                                    </td>

                                    <td class="fw-semibold">
                                        <?= esc($p['nama_penerbit']) ?>
                                    </td>

                                    <td>
                                        <small><?= esc($p['alamat']) ?></small>
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1">

                                            <!-- EDIT -->
                                            <a href="<?= base_url('penerbit/edit/' . $p['id_penerbit']) ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <!-- HAPUS -->
                                            <a href="<?= base_url('penerbit/delete/' . $p['id_penerbit']) ?>"
                                                onclick="return confirm('Hapus data ini?')"
                                                class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data penerbit belum tersedia
                                </td>
                            </tr>
                        <?php endif; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>