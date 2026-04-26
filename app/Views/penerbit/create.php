<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-building me-2"></i>Tambah Penerbit
        </h3>
    </div>

    <!-- CARD FORM -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('penerbit/store') ?>" method="post">

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Penerbit</label>
                    <input type="text"
                        name="nama_penerbit"
                        class="form-control"
                        placeholder="Masukkan nama penerbit"
                        required>
                </div>

                <!-- ALAMAT -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea name="alamat"
                        class="form-control"
                        rows="3"
                        placeholder="Masukkan alamat penerbit"></textarea>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="<?= base_url('penerbit') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>