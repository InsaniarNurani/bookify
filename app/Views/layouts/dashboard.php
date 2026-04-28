<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h4 class="mb-4 fw-bold">Selamat datang di Bookify</h4>

    <!-- CARD STAT -->
    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white p-4 shadow-lg rounded-4">
                <h6>Total Peminjaman</h6>
                <h2 class="fw-bold"><?= $total_peminjaman ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white p-4 shadow-lg rounded-4">
                <h6>Total Buku</h6>
                <h2 class="fw-bold"><?= $total_buku ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark p-4 shadow-lg rounded-4">
                <h6>Total Pengembalian</h6>
                <h2 class="fw-bold"><?= $total_pengembalian ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white p-4 shadow-lg rounded-4">
                <h6>Belum Dikonfirmasi</h6>
                <h2 class="fw-bold"><?= $notif_belum_konfirmasi ?></h2>
            </div>
        </div>

    </div>

    <!-- BUKU BARU -->
    <div class="mt-4">
        <h5 class="fw-bold mb-3">Buku Terbaru</h5>

        <div class="row">
            <?php foreach ($buku_baru as $buku): ?>
                <div class="col-md-3 mb-4">

                    <div class="card shadow-lg rounded-4 h-100">

                        <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>"
                            class="card-img-top"
                            style="height:260px; object-fit:cover; border-top-left-radius:15px; border-top-right-radius:15px;">

                        <div class="card-body text-center">

                            <h6 class="fw-bold"><?= $buku['judul'] ?></h6>

                            <!-- DIUBAH HANYA BAGIAN INI -->
                            <a href="<?= base_url('buku/detail/' . $buku['id_buku']) ?>">
                                Detail
                            </a>

                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>

</div>

<?= $this->endSection() ?>