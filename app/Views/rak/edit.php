<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Rak
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('rak/update/' . $rak['id_rak']) ?>" method="post">

                <!-- NAMA RAK -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Rak</label>
                    <input type="text"
                        name="nama_rak"
                        class="form-control"
                        value="<?= esc($rak['nama_rak']) ?>"
                        required>
                </div>

                <!-- LOKASI -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Lokasi</label>
                    <input type="text"
                        name="lokasi"
                        class="form-control"
                        value="<?= esc($rak['lokasi']) ?>">
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
                    </button>

                    <a href="<?= base_url('rak') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>