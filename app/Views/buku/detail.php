<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .book-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .book-cover {
        width: 100%;
        max-width: 180px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .info-label {
        font-weight: 600;
        color: #555;
        width: 160px;
    }

    .info-row {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 15px;
    }

    .btn {
        border-radius: 10px;
    }
</style>

<div class="container py-4">

    <div class="card shadow-sm book-card">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-book"></i> Detail Buku
            </h5>
        </div>

        <div class="card-body">

            <div class="row">

                <!-- COVER -->
                <div class="col-md-3 text-center mb-3">
                    <?php if ($buku['cover']): ?>
                        <img class="book-cover"
                            src="<?= base_url('uploads/buku/' . $buku['cover']) ?>">
                    <?php else: ?>
                        <div class="text-muted">Tidak ada cover</div>
                    <?php endif; ?>
                </div>

                <!-- INFO -->
                <div class="col-md-9">

                    <div class="info-row d-flex">
                        <div class="info-label">Judul</div>
                        <div><?= $buku['judul'] ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">ISBN</div>
                        <div><?= $buku['isbn'] ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Kategori</div>
                        <div><?= $buku['nama_kategori'] ?? '-' ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Penulis</div>
                        <div><?= $buku['nama_penulis'] ?? '-' ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Penerbit</div>
                        <div><?= $buku['nama_penerbit'] ?? '-' ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Rak</div>
                        <div><?= $buku['nama_rak'] ?> - <?= $buku['lokasi'] ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Tahun Terbit</div>
                        <div><?= $buku['tahun_terbit'] ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Jumlah</div>
                        <div><?= $buku['jumlah'] ?></div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Tersedia</div>
                        <div>
                            <span class="badge bg-success">
                                <?= $buku['tersedia'] ?>
                            </span>
                        </div>
                    </div>

                    <div class="info-row d-flex">
                        <div class="info-label">Deskripsi</div>
                        <div><?= $buku['deskripsi'] ?></div>
                    </div>

                </div>

            </div>

        </div>

        <!-- FOOTER BUTTON -->
        <div class="card-footer d-flex gap-2">
            <div class="mt-3">

                <a href="<?= base_url('/') ?>" class="btn btn-secondary">
                    Kembali ke Dashboard
                </a>

                <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
                    <a href="<?= base_url('buku') ?>" class="btn btn-primary">
                        Kembali ke Data Buku
                    </a>
                <?php endif; ?>

            </div>

            <a href="<?= base_url('buku/wa/' . $buku['id_buku']) ?>"
                target="_blank"
                class="btn btn-success">
                <i class="bi bi-whatsapp"></i> Kirim WA
            </a>

        </div>

    </div>

</div>

<?= $this->endSection() ?>