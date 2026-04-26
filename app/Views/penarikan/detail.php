<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div id="printArea">

        <!-- HEADER -->
        <div class="mb-4">
            <h3 class="fw-bold">
                <i class="bi bi-truck me-2"></i>Detail Penarikan
            </h3>
        </div>

        <!-- CARD -->
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>ID Penarikan</strong><br>
                        <?= $penarikan['id_penarikan'] ?? '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Peminjam</strong><br>
                        <?= $penarikan['nama_anggota'] ?? $penarikan['id_peminjaman'] ?? '-' ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Alamat Pengambilan</strong><br>
                        <?= $penarikan['alamat'] ?? '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Biaya</strong><br>
                        <span class="text-danger fw-bold">
                            Rp <?= number_format($penarikan['biaya'] ?? 0, 0, ',', '.') ?>
                        </span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Status</strong><br>

                        <?php if (($penarikan['status'] ?? '') == 'diajukan'): ?>
                            <span class="badge bg-warning text-dark">Diajukan</span>

                        <?php elseif (($penarikan['status'] ?? '') == 'menunggu_pembayaran'): ?>
                            <span class="badge bg-danger">Menunggu Pembayaran</span>

                        <?php elseif (($penarikan['status'] ?? '') == 'sudah_bayar'): ?>
                            <span class="badge bg-primary">Sudah Bayar</span>

                        <?php elseif (($penarikan['status'] ?? '') == 'diambil'): ?>
                            <span class="badge bg-success">Diambil</span>

                        <?php elseif (($penarikan['status'] ?? '') == 'selesai'): ?>
                            <span class="badge bg-secondary">Selesai</span>

                        <?php else: ?>
                            <span class="badge bg-light text-dark">-</span>
                        <?php endif; ?>

                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Tanggal Ambil</strong><br>
                        <?= $penarikan['tanggal_ambil'] ?? '-' ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Dibuat</strong><br>
                        <small><?= $penarikan['created_at'] ?? '-' ?></small>
                    </div>

                    <div class="col-md-6">
                        <strong>Terakhir Update</strong><br>
                        <small><?= $penarikan['updated_at'] ?? '-' ?></small>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-4 no-print">
        <a href="<?= base_url('penarikan') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <button onclick="window.print()" class="btn btn-success">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>

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