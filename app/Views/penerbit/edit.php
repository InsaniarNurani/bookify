<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Penerbit
        </h3>
    </div>

    <!-- CARD FORM -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('penerbit/update/' . $penerbit['id_penerbit']) ?>" method="post">

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Penerbit</label>
                    <input type="text"
                        name="nama_penerbit"
                        class="form-control"
                        value="<?= esc($penerbit['nama_penerbit']) ?>"
                        required>
                </div>

                <!-- ALAMAT -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Alamat</label>
                    <textarea name="alamat"
                        class="form-control"
                        rows="3"><?= esc($penerbit['alamat']) ?></textarea>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
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