<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-2">

    <!-- HEADER -->
    <div class="mb-3">
        <h4 class="fw-bold">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </h4>
        <p class="text-muted mb-0">
            Selamat datang di <b>Bookify App</b> 👋
        </p>
    </div>

    <!-- 🔥 STATISTIK -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <small>Total Buku</small>
                    <h4><?= $total_buku ?? 0 ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <small>Peminjaman</small>
                    <h4><?= $total_pinjam ?? 0 ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-warning text-dark">
                <div class="card-body">
                    <small>Pengembalian</small>
                    <h4><?= $total_kembali ?? 0 ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-danger text-white">
                <div class="card-body">
                    <small>Penarikan</small>
                    <h4><?= $total_penarikan ?? 0 ?></h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 bg-dark text-white">
                <div class="card-body">
                    <small>Transaksi</small>
                    <h4><?= $total_transaksi ?? 0 ?></h4>
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

                <?php if (!empty($buku_terbaru)): ?>
                    <?php foreach ($buku_terbaru as $b): ?>
                        <div class="col-md-2 col-6 text-center">

                            <div class="card border-0 shadow-sm h-100">
                                <img src="<?= base_url('uploads/buku/' . ($b['cover'] ?? 'default.png')) ?>"
                                    class="card-img-top"
                                    style="height:140px; object-fit:cover;">

                                <div class="card-body p-2">
                                    <small class="fw-semibold d-block text-truncate">
                                        <?= $b['judul'] ?>
                                    </small>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-muted">Belum ada buku</p>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>