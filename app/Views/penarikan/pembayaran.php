<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-cash-coin me-2"></i>Pembayaran Penarikan
        </h3>
    </div>

    <!-- DETAIL -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Detail Penarikan</h5>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>ID Penarikan</strong><br>
                    <?= $penarikan['id_penarikan'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>ID Peminjaman</strong><br>
                    <?= $penarikan['id_peminjaman'] ?>
                </div>

                <div class="col-md-12 mb-2">
                    <strong>Alamat</strong><br>
                    <?= $penarikan['alamat'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Biaya</strong><br>
                    <span class="text-danger fw-bold">
                        Rp <?= number_format($penarikan['biaya'], 0, ',', '.') ?>
                    </span>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Status</strong><br>

                    <?php if ($penarikan['status'] == 'lunas'): ?>
                        <span class="badge bg-success">Lunas</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">
                            <?= ucfirst($penarikan['status']) ?>
                        </span>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <!-- FORM -->
    <?php if ($penarikan['status'] != 'lunas'): ?>

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Form Pembayaran</h5>

                <form action="<?= base_url('penarikan/prosesBayar/' . $penarikan['id_penarikan']) ?>" method="post">

                    <!-- METODE -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Metode Pembayaran</label>
                        <select name="metode" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash">Cash</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet</option>
                        </select>
                    </div>

                    <!-- JUMLAH -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Bayar</label>
                        <input type="number"
                            name="jumlah_bayar"
                            class="form-control"
                            value="<?= $penarikan['biaya'] ?>"
                            required>
                    </div>

                    <!-- BUTTON -->
                    <div>
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="bi bi-check-circle"></i> Bayar Sekarang
                        </button>
                    </div>

                </form>

            </div>
        </div>

    <?php else: ?>

        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i> Pembayaran sudah lunas
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>