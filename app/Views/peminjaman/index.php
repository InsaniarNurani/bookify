<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-journal-text me-2"></i>Data peminjaman buku
        </h3>

        <?php if (session()->get('role') == 'anggota'): ?>
            <a href="<?= base_url('peminjaman/create') ?>" class="btn btn-primary">
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
                            <th>ID</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Pengantaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($peminjaman as $p): ?>
                            <tr>

                                <td class="text-center"><?= $p['id_peminjaman'] ?></td>

                                <td><?= $p['nama_anggota'] ?></td>

                                <!-- BUKU -->
                                <td>
                                    <?php foreach ($p['buku'] as $b): ?>
                                        <div class="d-flex align-items-center mb-1">
                                            <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>"
                                                class="me-2 rounded"
                                                style="width:40px;height:55px;object-fit:cover;">
                                            <small><?= $b['judul'] ?></small>
                                        </div>
                                    <?php endforeach; ?>
                                </td>

                                <!-- TANGGAL -->
                                <td>
                                    <small>
                                        <b>Pinjam:</b><br><?= $p['tanggal_pinjam'] ?><br>
                                        <b>Kembali:</b><br><?= $p['tanggal_kembali'] ?>
                                    </small>
                                </td>

                                <!-- STATUS -->
                                <td class="text-center">
                                    <?php if ($p['status'] == 'dipinjam'): ?>
                                        <span class="badge bg-primary">Dipinjam</span>
                                    <?php elseif ($p['status'] == 'menunggu_bayar'): ?>
                                        <span class="badge bg-warning text-dark">Menunggu Bayar</span>
                                    <?php elseif ($p['status'] == 'kembali'): ?>
                                        <span class="badge bg-success">Kembali</span>
                                    <?php elseif ($p['status'] == 'terlambat'): ?>
                                        <span class="badge bg-danger">Terlambat</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary"><?= $p['status'] ?></span>
                                    <?php endif; ?>
                                </td>

                                <!-- PENGANTARAN -->
                                <td>
                                    <?php if (($p['metode_pengantaran'] ?? '') == 'ambil'): ?>

                                        <span class="badge bg-info text-dark">
                                            <i class="bi bi-shop"></i> Ambil
                                        </span>

                                    <?php else: ?>

                                        <?php if ($p['status_pengiriman'] == 'menunggu_konfirmasi'): ?>
                                            <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>

                                            <?php if (session()->get('role') == 'petugas'): ?>
                                                <br>
                                                <a href="<?= base_url('peminjaman/konfirmasi/' . $p['id_peminjaman']) ?>"
                                                    class="btn btn-sm btn-warning mt-1">
                                                    ✔ Konfirmasi
                                                </a>
                                            <?php endif; ?>

                                        <?php elseif ($p['status_pengiriman'] == 'menunggu_pembayaran'): ?>

                                            <?php if (session()->get('role') == 'anggota'): ?>
                                                <a href="<?= base_url('peminjaman/pembayaran/' . $p['id_peminjaman']) ?>"
                                                    class="btn btn-sm btn-primary">
                                                    💳 Bayar
                                                </a>
                                            <?php else: ?>
                                                <span class="badge bg-primary">Menunggu Pembayaran</span>
                                            <?php endif; ?>

                                        <?php elseif ($p['status_pengiriman'] == 'diantar'): ?>
                                            <span class="badge bg-success">🚚 Diantar</span>

                                            <?php if (session()->get('role') == 'petugas'): ?>
                                                <br>
                                                <a href="<?= base_url('peminjaman/selesai/' . $p['id_peminjaman']) ?>"
                                                    class="btn btn-sm btn-success mt-1">
                                                    ✔ Selesai
                                                </a>
                                            <?php endif; ?>

                                        <?php elseif ($p['status_pengiriman'] == 'selesai'): ?>
                                            <span class="badge bg-secondary">✔ Selesai</span>
                                        <?php endif; ?>

                                    <?php endif; ?>
                                </td>

                                <!-- AKSI -->
                                <td>

                                    <div class="d-flex flex-wrap gap-1">

                                        <!-- DETAIL -->
                                        <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>"
                                            class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- PETUGAS -->
                                        <?php if (session()->get('role') == 'petugas'): ?>

                                            <?php if ($p['status'] == 'dipinjam'): ?>
                                                <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>"
                                                    onclick="return confirm('Yakin?')"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-arrow-return-left"></i>
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- ANGGOTA -->
                                        <?php if (session()->get('role') == 'anggota'): ?>

                                            <?php if ($p['status'] == 'dipinjam'): ?>
                                                <a href="<?= base_url('peminjaman/perpanjang/' . $p['id_peminjaman']) ?>"
                                                    onclick="return confirm('Perpanjang 7 hari?')"
                                                    class="btn btn-sm btn-primary">
                                                    🔁
                                                </a>
                                            <?php endif; ?>

                                            <?php if (($p['metode_pengantaran'] ?? '') != 'ambil'): ?>
                                                <a href="<?= base_url('peminjaman/ajukan/' . $p['id_peminjaman']) ?>"
                                                    onclick="return confirm('Ajukan penarikan?')"
                                                    class="btn btn-sm btn-secondary">
                                                    🚚
                                                </a>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- HAPUS -->
                                        <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>"
                                            onclick="return confirm('Hapus data ini?')"
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