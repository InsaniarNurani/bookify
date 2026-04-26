<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-person-plus me-2"></i>Tambah Penulis
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('penulis/store') ?>" method="post">

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Penulis</label>
                    <input type="text"
                        name="nama_penulis"
                        class="form-control"
                        placeholder="Masukkan nama penulis"
                        required
                        autofocus>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="<?= base_url('penulis') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>