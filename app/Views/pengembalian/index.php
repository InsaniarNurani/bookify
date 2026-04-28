<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-arrow-return-left me-2"></i>Data Pengembalian
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-light text-center">
                        <tr>
                            <th>ID</th>
                            <th>Peminjaman</th>
                            <th>Anggota</th>
                            <th>Tanggal</th>
                            <th>Denda</th>
                            <th>Status</th>
                            <th>Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($pengembalian as $p): ?>
                            <tr>

                                <td class="text-center">
                                    <?= $p['id_pengembalian'] ?>
                                </td>

                                <td>
                                    <small>
                                        ID: <?= $p['id_peminjaman'] ?><br>
                                        <?= $p['tanggal_pinjam'] ?? '-' ?>
                                    </small>
                                </td>

                                <td>
                                    <?= $p['nama_anggota'] ?? '-' ?>
                                </td>

                                <td>
                                    <small>
                                        Kembali:<br>
                                        <?= $p['tanggal_dikembalikan'] ?>
                                    </small>
                                </td>

                                <!-- DENDA -->
                                <td>
                                    <?php if (($p['denda'] ?? 0) > 0): ?>
                                        <span class="badge bg-danger">
                                            Rp <?= number_format($p['denda'], 0, ',', '.') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">0</span>
                                    <?php endif; ?>
                                </td>

                                <!-- STATUS -->
                                <td class="text-center">
                                    <?php if (($p['denda'] ?? 0) > 0): ?>
                                        <span class="badge bg-danger">Terlambat</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    <?php endif; ?>
                                </td>

                                <!-- STATUS BAYAR -->
                                <td class="text-center">
                                    <?php if (($p['denda'] ?? 0) == 0): ?>
                                        <span class="badge bg-secondary">-</span>
                                    <?php else: ?>
                                        <?php if (($p['status_bayar'] ?? 'belum_bayar') == 'lunas'): ?>
                                            <span class="badge bg-success">Lunas</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Belum</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>

                                <!-- AKSI -->
                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <!-- DETAIL -->
                                        <a href="<?= base_url('pengembalian/detail/' . $p['id_pengembalian']) ?>"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>



                                        <!-- HAPUS -->
                                        <a href="<?= base_url('pengembalian/delete/' . $p['id_pengembalian']) ?>"
                                            onclick="return confirm('Hapus data?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>

                                        <!-- BAYAR DENDA -->
                                        <?php if (($p['denda'] ?? 0) > 0 && ($p['status_bayar'] ?? 'belum_bayar') == 'belum_bayar'): ?>
                                            <a href="<?= base_url('pengembalian/bayar/' . $p['id_pengembalian']) ?>"
                                                class="btn btn-sm btn-primary">
                                                💳
                                            </a>
                                        <?php endif; ?>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>