<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-truck me-2"></i>Data Penarikan
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
                            <th>Anggota</th>
                            <th>Alamat</th>
                            <th>Biaya</th>
                            <th>Status</th>
                            <th>Tanggal Ambil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($penarikan as $p): ?>
                            <tr>

                                <td class="text-center"><?= $p['id_penarikan'] ?></td>

                                <td><?= $p['nama_anggota'] ?></td>

                                <td>
                                    <small><?= $p['alamat'] ?></small>
                                </td>

                                <td>
                                    <span class="fw-bold text-danger">
                                        Rp <?= number_format($p['biaya'], 0, ',', '.') ?>
                                    </span>
                                </td>

                                <!-- STATUS -->
                                <td class="text-center">
                                    <?php if ($p['status'] == 'diajukan'): ?>
                                        <span class="badge bg-warning text-dark">Diajukan</span>

                                    <?php elseif ($p['status'] == 'menunggu_pembayaran'): ?>
                                        <span class="badge bg-danger">Menunggu Bayar</span>

                                    <?php elseif ($p['status'] == 'sudah_bayar'): ?>
                                        <span class="badge bg-primary">Sudah Bayar</span>

                                    <?php elseif ($p['status'] == 'diambil'): ?>
                                        <span class="badge bg-success">Diambil</span>

                                    <?php elseif ($p['status'] == 'selesai'): ?>
                                        <span class="badge bg-secondary">Selesai</span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <?= $p['tanggal_ambil'] ?>
                                </td>

                                <!-- AKSI -->
                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <!-- DIAJUKAN -->
                                        <?php if ($p['status'] == 'diajukan'): ?>

                                            <?php if (session()->get('role') == 'petugas'): ?>
                                                <a href="<?= base_url('penarikan/konfirmasi/' . $p['id_penarikan']) ?>"
                                                    class="btn btn-sm btn-warning">
                                                    ✔
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- MENUNGGU BAYAR -->
                                        <?php if ($p['status'] == 'menunggu_pembayaran'): ?>

                                            <?php if (session()->get('role') == 'anggota'): ?>
                                                <a href="<?= base_url('penarikan/bayar/' . $p['id_penarikan']) ?>"
                                                    class="btn btn-sm btn-primary">
                                                    💳
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- SUDAH BAYAR -->
                                        <?php if ($p['status'] == 'sudah_bayar'): ?>

                                            <?php if (session()->get('role') == 'petugas'): ?>
                                                <a href="<?= base_url('penarikan/ambil/' . $p['id_penarikan']) ?>"
                                                    class="btn btn-sm btn-success">
                                                    🚚
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- DIAMBIL -->
                                        <?php if ($p['status'] == 'diambil'): ?>

                                            <?php if (session()->get('role') == 'petugas'): ?>
                                                <a href="<?= base_url('penarikan/selesai/' . $p['id_penarikan']) ?>"
                                                    class="btn btn-sm btn-success">
                                                    ✔
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- DETAIL -->
                                        <a href="<?= base_url('penarikan/detail/' . $p['id_penarikan']) ?>"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- HAPUS -->
                                        <a href="<?= base_url('penarikan/delete/' . $p['id_penarikan']) ?>"
                                            onclick="return confirm('Hapus data?')"
                                            class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </a>

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