<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-arrow-return-left me-2"></i>Tambah Pengembalian
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post" action="<?= base_url('pengembalian/store') ?>">

                <!-- PEMINJAMAN -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Peminjaman</label>
                    <select name="id_peminjaman" class="form-select" required>
                        <option value="">-- Pilih Peminjaman --</option>
                        <?php foreach ($peminjaman as $p): ?>
                            <option value="<?= $p['id_peminjaman'] ?>">
                                ID: <?= $p['id_peminjaman'] ?> |
                                Tgl: <?= $p['tanggal_pinjam'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TANGGAL -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Dikembalikan</label>
                    <input type="date"
                        name="tanggal_dikembalikan"
                        class="form-control"
                        required>
                </div>

                <!-- DENDA -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Denda</label>
                    <input type="number"
                        name="denda"
                        class="form-control"
                        value="0"
                        step="0.01">
                    <small class="text-muted">
                        Isi jika ada keterlambatan
                    </small>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="<?= base_url('pengembalian') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>