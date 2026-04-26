<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-credit-card me-2"></i>Pembayaran Ongkir
        </h3>
    </div>

    <?php
    $ongkir = 10000;
    $total = ($total ?? 0) + $ongkir;
    ?>

    <!-- RINGKASAN -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <span>Ongkir</span>
                <strong>Rp <?= number_format($ongkir, 0, ',', '.') ?></strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Total Bayar</span>
                <strong class="text-primary fs-5">
                    Rp <?= number_format($total, 0, ',', '.') ?>
                </strong>
            </div>

        </div>
    </div>

    <!-- FORM -->
    <form method="post" action="<?= base_url('peminjaman/bayar/' . $id) ?>" enctype="multipart/form-data">

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="mb-3 fw-bold">Pilih Metode Pembayaran</h5>

                <!-- METODE -->
                <div class="row g-3">

                    <!-- DANA -->
                    <div class="col-md-4">
                        <label class="w-100">
                            <input type="radio" name="metode" value="dana" class="d-none" onchange="showMetode()" required>
                            <div class="border rounded p-3 text-center metode-box">
                                <i class="bi bi-wallet2 fs-3 text-primary"></i>
                                <div>DANA</div>
                            </div>
                        </label>
                    </div>

                    <!-- TRANSFER -->
                    <div class="col-md-4">
                        <label class="w-100">
                            <input type="radio" name="metode" value="transfer" class="d-none" onchange="showMetode()">
                            <div class="border rounded p-3 text-center metode-box">
                                <i class="bi bi-bank fs-3 text-success"></i>
                                <div>Transfer Bank</div>
                            </div>
                        </label>
                    </div>

                    <!-- COD -->
                    <div class="col-md-4">
                        <label class="w-100">
                            <input type="radio" name="metode" value="cod" class="d-none" onchange="showMetode()">
                            <div class="border rounded p-3 text-center metode-box">
                                <i class="bi bi-truck fs-3 text-warning"></i>
                                <div>COD</div>
                            </div>
                        </label>
                    </div>

                </div>

                <!-- INFO DINAMIS -->
                <div id="infoMetode" class="alert alert-info mt-4 d-none"></div>

                <!-- UPLOAD -->
                <div class="mt-4">
                    <label class="form-label fw-bold">
                        Upload Bukti (wajib untuk DANA / Transfer)
                    </label>
                    <input type="file" name="bukti" class="form-control" accept="image/*">
                </div>

                <!-- BUTTON -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-check-circle"></i> Konfirmasi Pembayaran
                    </button>
                </div>

            </div>
        </div>

    </form>

</div>

<!-- STYLE TAMBAHAN -->
<style>
    .metode-box {
        cursor: pointer;
        transition: 0.3s;
    }

    .metode-box:hover {
        background: #f8f9fa;
        transform: scale(1.03);
    }

    input[type="radio"]:checked+.metode-box {
        border: 2px solid #0d6efd;
        background: #e7f1ff;
    }
</style>

<!-- SCRIPT -->
<script>
    function showMetode() {
        let metode = document.querySelector('input[name="metode"]:checked').value;
        let info = document.getElementById("infoMetode");

        info.classList.remove("d-none");

        if (metode === "dana") {
            info.innerHTML = `
                <b>DANA</b><br>
                Nomor: 0812-3456-7890<br>
                A/N: Insaniar Nurani
            `;
        } else if (metode === "transfer") {
            info.innerHTML = `
                <b>Transfer Bank</b><br>
                BRI: 123-456-7890<br>
                A/N: Insaniar Nurani
            `;
        } else if (metode === "cod") {
            info.innerHTML = `
                <b>COD</b><br>
                Bayar langsung saat buku diantar.
            `;
        }
    }
</script>

<?= $this->endSection() ?>