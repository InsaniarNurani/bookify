<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-cash-coin me-2"></i>Pembayaran Denda
        </h3>
    </div>

    <!-- INFO -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Detail Pengembalian</h5>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>ID Pengembalian</strong><br>
                    <?= $pengembalian['id_pengembalian'] ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Nama Anggota</strong><br>
                    <?= $pengembalian['nama_anggota'] ?? '-' ?>
                </div>

                <div class="col-md-6 mb-2">
                    <strong>Total Denda</strong><br>
                    <span class="badge bg-danger fs-6">
                        Rp <?= number_format($pengembalian['denda'] ?? 0, 0, ',', '.') ?>
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- FORM -->
    <div class="card shadow-sm">
        <div class="card-body">

            <form method="post"
                action="<?= base_url('pengembalian/prosesBayar/' . $pengembalian['id_pengembalian']) ?>"
                enctype="multipart/form-data">

                <!-- METODE -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Metode Pembayaran</label>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="metode"
                            value="transfer"
                            required>
                        <label class="form-check-label">
                            Transfer Bank
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input"
                            type="radio"
                            name="metode"
                            value="cod">
                        <label class="form-check-label">
                            COD (Bayar di Tempat)
                        </label>
                    </div>
                </div>

                <!-- INFO DINAMIS -->
                <div id="infoMetode"
                    class="alert alert-info d-none"></div>

                <!-- UPLOAD -->
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        Upload Bukti (Wajib jika Transfer)
                    </label>
                    <input type="file"
                        name="bukti"
                        class="form-control"
                        accept="image/*">
                </div>

                <!-- BUTTON -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">
                        <i class="bi bi-check-circle"></i> Bayar Sekarang
                    </button>

                    <a href="<?= base_url('pengembalian') ?>"
                        class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- SCRIPT INFO -->
<script>
    document.querySelectorAll('input[name="metode"]').forEach(el => {
        el.addEventListener('change', function() {

            let info = document.getElementById('infoMetode');

            if (this.value === 'transfer') {
                info.classList.remove('d-none');
                info.innerHTML = `
                    <b>Transfer Bank:</b><br>
                    Bank BRI: 123-456-7890<br>
                    A/N: insaniar nurani
                `;
            } else {
                info.classList.remove('d-none');
                info.innerHTML = `
                    <b>COD:</b><br>
                    Bayar saat bertemu petugas.
                `;
            }

        });
    });
</script>

<?= $this->endSection() ?>