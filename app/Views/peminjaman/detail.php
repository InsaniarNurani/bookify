<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div id="printArea">

        <!-- HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold">
                <i class="bi bi-receipt me-2"></i>Detail Peminjaman
            </h3>
        </div>

        <!-- CARD INFO -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Nama Anggota:</strong><br>
                        <?= $peminjaman['nama_anggota'] ?? '-' ?>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Status:</strong><br>

                        <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>

                            <?php if (($peminjaman['status_pengiriman'] ?? '') == 'menunggu_konfirmasi'): ?>
                                <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>

                            <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'menunggu_pembayaran'): ?>
                                <span class="badge bg-danger">Menunggu Pembayaran</span>

                            <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'siap_dikirim'): ?>
                                <span class="badge bg-primary">Siap Dikirim</span>

                            <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'diantar'): ?>
                                <span class="badge bg-success">Sedang Diantar</span>

                            <?php else: ?>
                                <span class="badge bg-secondary">-</span>
                            <?php endif; ?>

                        <?php else: ?>
                            <span class="badge bg-success">
                                <?= $peminjaman['status'] ?? '-' ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 mb-2">
                        <strong>Tanggal Pinjam:</strong><br>
                        <?= $peminjaman['tanggal_pinjam'] ?? '-' ?>
                    </div>

                    <div class="col-md-4 mb-2">
                        <strong>Tanggal Kembali:</strong><br>
                        <?= $peminjaman['tanggal_kembali'] ?? '-' ?>
                    </div>

                    <div class="col-md-4 mb-2">
                        <strong>Metode:</strong><br>
                        <?= ucfirst($peminjaman['metode_pengantaran'] ?? '-') ?>
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Ongkir:</strong><br>
                        <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>
                            Rp <?= number_format($peminjaman['ongkir'] ?? 0, 0, ',', '.') ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mt-2">
                        <strong>Total Bayar:</strong><br>
                        <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>
                            Rp <?= number_format($peminjaman['total_bayar'] ?? 0, 0, ',', '.') ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12 mt-3">
                        <strong>Denda:</strong><br>
                        <?php if (!empty($peminjaman['denda']) && $peminjaman['denda'] > 0): ?>
                            <span class="badge bg-danger">
                                Rp <?= number_format($peminjaman['denda'], 0, ',', '.') ?>
                            </span>
                        <?php else: ?>
                            <span class="badge bg-success">Tidak ada denda</span>
                        <?php endif; ?>
                    </div>

                </div>

            </div>
        </div>

        <!-- CARD BUKU -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-book me-2"></i>Detail Buku
                </h5>

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

                            <?php if (!empty($peminjaman['buku'])): ?>
                                <?php foreach ($peminjaman['buku'] as $b): ?>
                                    <tr>
                                        <td>
                                            <img src="<?= base_url('uploads/buku/' . ($b['cover'] ?? 'default.png')) ?>"
                                                class="img-thumbnail"
                                                style="width:60px; height:80px; object-fit:cover;">
                                        </td>
                                        <td class="text-start">
                                            <?= $b['judul'] ?? '-' ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                <?= $b['jumlah'] ?? 1 ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">Tidak ada data buku</td>
                                </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-4 no-print">
        <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <button onclick="window.print()" class="btn btn-success">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>

</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printArea,
        #printArea * {
            visibility: visible;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }
    }
</style>

<?= $this->endSection() ?>