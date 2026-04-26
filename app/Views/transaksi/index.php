<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-cash-coin me-2"></i>Data Transaksi
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th width="80">ID</th>
                            <th>Nama Anggota</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($transaksi)): ?>
                            <?php foreach ($transaksi as $t): ?>
                                <tr>

                                    <!-- ID -->
                                    <td class="text-center">
                                        <?= $t['id_transaksi'] ?>
                                    </td>

                                    <!-- NAMA -->
                                    <td class="fw-semibold">
                                        <?= esc($t['nama_anggota'] ?? '-') ?>
                                    </td>

                                    <!-- METODE -->
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?= strtoupper($t['metode_pembayaran']) ?>
                                        </span>
                                    </td>

                                    <!-- STATUS -->
                                    <td class="text-center">
                                        <?php if ($t['status'] == 'lunas'): ?>
                                            <span class="badge bg-success">Lunas</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Belum Bayar</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- TANGGAL -->
                                    <td>
                                        <small><?= $t['tanggal'] ?></small>
                                    </td>

                                    <!-- AKSI -->
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">

                                            <!-- DETAIL -->
                                            <a href="<?= base_url('transaksi/detail/' . $t['id_transaksi']) ?>"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <!-- HAPUS -->
                                            <a href="<?= base_url('transaksi/delete/' . $t['id_transaksi']) ?>"
                                                onclick="return confirm('Hapus data?')"
                                                class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </a>

                                            <!-- BAYAR -->
                                            <?php if ($t['status'] == 'belum_bayar'): ?>
                                                <a href="<?= base_url('transaksi/bayar/' . $t['id_transaksi']) ?>"
                                                    class="btn btn-sm btn-success">
                                                    <i class="bi bi-credit-card"></i>
                                                </a>
                                            <?php endif; ?>

                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data transaksi belum tersedia
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