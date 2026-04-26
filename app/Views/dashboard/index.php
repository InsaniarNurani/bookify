<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <h4 class="mb-4 fw-bold">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </h4>

    <!-- 🔥 STATISTIK -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h6>Total Buku</h6>
                    <h3><?= $total_buku ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <h6>Peminjaman</h6>
                    <h3><?= $total_pinjam ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark">
                <div class="card-body">
                    <h6>Pengembalian</h6>
                    <h3><?= $total_kembali ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white">
                <div class="card-body">
                    <h6>Penarikan</h6>
                    <h3><?= $total_penarikan ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-dark text-white">
                <div class="card-body">
                    <h6>Transaksi</h6>
                    <h3><?= $total_transaksi ?></h3>
                </div>
            </div>
        </div>

    </div>

    <!-- 📚 KOLEKSI BUKU -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-semibold">
            📚 Koleksi Buku Terbaru
        </div>

        <div class="card-body">
            <div class="row g-3">

                <?php foreach ($buku_terbaru as $b): ?>
                    <div class="col-md-2 col-6 text-center">

                        <div class="card border-0 shadow-sm h-100">
                            <img src="<?= base_url('uploads/buku/' . ($b['cover'] ?? 'default.png')) ?>"
                                class="card-img-top"
                                style="height:150px; object-fit:cover;">

                            <div class="card-body p-2">
                                <small class="fw-semibold d-block text-truncate">
                                    <?= $b['judul'] ?>
                                </small>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>