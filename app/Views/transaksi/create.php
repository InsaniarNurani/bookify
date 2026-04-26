<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-cash-stack me-2"></i>Tambah Transaksi
        </h3>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post" action="<?= base_url('transaksi/store') ?>">

                <!-- ID PEMINJAMAN -->
                <div class="mb-3">
                    <label class="form-label fw-bold">ID Peminjaman</label>
                    <input type="text"
                        name="id_peminjaman"
                        class="form-control"
                        placeholder="Masukkan ID peminjaman"
                        required>
                </div>

                <!-- JENIS -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Transaksi</label>
                    <select name="jenis" class="form-select" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="denda">Denda</option>
                        <option value="pengiriman">Pengiriman</option>
                        <option value="penarikan">Penarikan</option>
                    </select>
                </div>

                <!-- JUMLAH -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah</label>
                    <input type="number"
                        name="jumlah"
                        class="form-control"
                        placeholder="Masukkan jumlah pembayaran"
                        required>
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>

                    <a href="<?= base_url('transaksi') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>