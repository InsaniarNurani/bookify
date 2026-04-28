<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
            </h3>
            <small class="text-muted">
                Tambahkan kategori buku baru
            </small>
        </div>

        <a href="<?= base_url('kategori') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="post" action="<?= base_url('kategori/store') ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Nama Kategori
                    </label>

                    <input type="text"
                        name="nama_kategori"
                        class="form-control"
                        placeholder="Masukkan nama kategori"
                        required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>