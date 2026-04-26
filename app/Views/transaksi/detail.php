<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4" id="printArea">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-receipt me-2"></i>Detail Transaksi
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Nama Anggota</strong><br>
                    <?= $transaksi['nama_anggota'] ?? '-' ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Metode Pengantaran</strong><br>
                    <?= ucfirst($transaksi['metode_pengantaran'] ?? '-') ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Metode Pembayaran</strong><br>
                    <?= strtoupper($transaksi['metode_pembayaran'] ?? '-') ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Tanggal</strong><br>
                    <?= $transaksi['tanggal'] ?? '-' ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Ongkir</strong><br>
                    <span class="text-primary fw-bold">
                        Rp <?= number_format($transaksi['ongkir'] ?? 0, 0, ',', '.') ?>
                    </span>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Total Bayar</strong><br>
                    <span class="text-danger fw-bold fs-5">
                        Rp <?= number_format($transaksi['total_bayar'] ?? 0, 0, ',', '.') ?>
                    </span>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status</strong><br>
                    <?php if (($transaksi['status'] ?? '') == 'lunas'): ?>
                        <span class="badge bg-success">Lunas</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Belum Bayar</span>
                    <?php endif; ?>
                </div>

            </div>

            <hr>

            <!-- BUKTI -->
            <h5 class="fw-bold mb-3">Bukti Pembayaran</h5>

            <?php if (!empty($transaksi['bukti_pembayaran'])): ?>
                <img src="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>"
                    class="img-thumbnail"
                    style="max-width:250px;">
            <?php else: ?>
                <p class="text-muted">Tidak ada bukti pembayaran</p>
            <?php endif; ?>

        </div>
    </div>

</div>

<!-- BUTTON -->
<div class="container mt-3 no-print">
    <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <button onclick="window.print()" class="btn btn-success">
        <i class="bi bi-printer"></i> Print
    </button>
</div>

<!-- PRINT STYLE -->
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