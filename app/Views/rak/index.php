<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-bookshelf me-2"></i>Data Rak
        </h3>

        <?php if (session()->get('role') == 'admin') : ?>
            <a href="<?= base_url('rak/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah
            </a>
        <?php endif; ?>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th width="80">ID</th>
                            <th>Nama Rak</th>
                            <th>Lokasi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($rak)): ?>
                            <?php foreach ($rak as $r): ?>
                                <tr>

                                    <td class="text-center">
                                        <?= $r['id_rak'] ?>
                                    </td>

                                    <td class="fw-semibold">
                                        <?= esc($r['nama_rak']) ?>
                                    </td>

                                    <td>
                                        <small><?= esc($r['lokasi']) ?></small>
                                    </td>

                                    <td>
                                        <?php if (session()->get('role') == 'admin') : ?>
                                            <div class="d-flex gap-1">

                                                <!-- EDIT -->
                                                <a href="<?= base_url('rak/edit/' . $r['id_rak']) ?>"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <!-- HAPUS -->
                                                <a href="<?= base_url('rak/delete/' . $r['id_rak']) ?>"
                                                    onclick="return confirm('Yakin mau hapus rak ini?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </a>

                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data rak belum tersedia
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