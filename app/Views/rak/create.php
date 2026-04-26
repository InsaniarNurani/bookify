<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-bookshelf me-2"></i>Tambah Rak
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('rak/store') ?>" method="post">

                <!-- NAMA RAK -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Rak</label>
                    <input type="text"
                        name="nama_rak"
                        class="form-control"
                        placeholder="Contoh: Rak A1"
                        required
                        autofocus>
                </div>

                <!-- LOKASI -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Lokasi</label>
                    <input type="text"
                        name="lokasi"
                        class="form-control"
                        placeholder="Contoh: Lantai 2 / Ruang Baca">
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
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