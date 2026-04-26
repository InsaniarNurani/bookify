<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-receipt me-2"></i>Detail Pengembalian
        </h3>
    </div>

    <!-- DATA PENGEMBALIAN -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">📌 Data Pengembalian</h5>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>ID Peminjaman</strong><br>
                    <?= $pengembalian['id_peminjaman'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Tanggal Dikembalikan</strong><br>
                    <?= $pengembalian['tanggal_dikembalikan'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Denda</strong><br>
                    <?php if ($pengembalian['denda'] > 0): ?>
                        <span class="badge bg-danger">
                            Rp <?= number_format($pengembalian['denda'], 0, ',', '.') ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-success">Tidak ada denda</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- DATA PEMINJAMAN -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">📚 Data Peminjaman</h5>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>Nama Anggota</strong><br>
                    <?= $pengembalian['nama_anggota'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Metode Pengantaran</strong><br>
                    <?= ucfirst($pengembalian['metode_pengantaran']) ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Tanggal Pinjam</strong><br>
                    <?= $pengembalian['tanggal_pinjam'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Tanggal Kembali</strong><br>
                    <?= $pengembalian['tanggal_kembali'] ?>
                </div>

                <div class="col-md-12 mb-2">
                    <strong>Alamat</strong><br>
                    <?= $pengembalian['alamat'] ?? '-' ?>
                </div>
            </div>

        </div>
    </div>

    <!-- DETAIL BUKU -->
    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="fw-bold mb-3">📖 Detail Buku</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle text-center">

                    <thead class="table-light">
                        <tr>
                            <th>Cover</th>
                            <th>Judul</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($buku as $b): ?>
                            <tr>
                                <td>
                                    <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>"
                                        class="img-thumbnail"
                                        style="width:60px;height:80px;object-fit:cover;">
                                </td>
                                <td class="text-start">
                                    <?= $b['judul'] ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= $b['jumlah'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- BUTTON -->
    <div class="mt-4">
        <a href="<?= base_url('pengembalian') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>

<?= $this->endSection() ?>