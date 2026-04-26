<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Pengembalian
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="<?= base_url('pengembalian/update/' . $pengembalian['id_pengembalian']) ?>" method="post">

                <!-- PEMINJAMAN -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Peminjaman</label>
                    <select name="id_peminjaman" class="form-select" required>
                        <?php foreach ($peminjaman as $p): ?>
                            <option value="<?= $p['id_peminjaman'] ?>"
                                <?= $p['id_peminjaman'] == $pengembalian['id_peminjaman'] ? 'selected' : '' ?>>

                                ID: <?= $p['id_peminjaman'] ?> |
                                <?= $p['tanggal_pinjam'] ?? '' ?>
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
                        value="<?= esc($pengembalian['tanggal_dikembalikan']) ?>"
                        required>
                </div>

                <!-- DENDA -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Denda</label>
                    <input type="number"
                        name="denda"
                        class="form-control"
                        value="<?= esc($pengembalian['denda']) ?>"
                        step="0.01">
                    <small class="text-muted">Isi jika ada keterlambatan</small>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update
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