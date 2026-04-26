<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pembayaran Penarikan</h3>

<?php
$biaya = $penarikan['biaya'] ?? 10000;
?>

<p><b>ID Penarikan:</b> <?= $penarikan['id_penarikan'] ?></p>
<p><b>ID Peminjaman:</b> <?= $penarikan['id_peminjaman'] ?></p>

<hr>

<p><b>Biaya Penarikan:</b> Rp <?= number_format($biaya, 0, ',', '.') ?></p>

<hr>

<form method="post"
    action="<?= base_url('penarikan/prosesBayar/' . $penarikan['id_penarikan']) ?>"
    enctype="multipart/form-data">

    <p><b>Pilih Metode Pembayaran:</b></p>

    <label>
        <input type="radio" name="metode" value="dana" onchange="showMetode()" required>
        DANA
    </label><br>

    <label>
        <input type="radio" name="metode" value="transfer" onchange="showMetode()">
        Transfer Bank
    </label><br>

    <label>
        <input type="radio" name="metode" value="cod" onchange="showMetode()">
        COD (Bayar di Tempat)
    </label>

    <br><br>

    <!-- INFO METODE -->
    <div id="infoMetode" style="padding:10px;border:1px solid #ccc;display:none;"></div>

    <br>

    <p><b>Upload Bukti Pembayaran (WAJIB untuk DANA / Transfer):</b></p>
    <input type="file" name="bukti" accept="image/*">

    <br><br>

    <button type="submit" style="padding:10px 20px;background:black;color:white;">
        Konfirmasi Pembayaran
    </button>

</form>

<script>
    function showMetode() {
        let metode = document.querySelector('input[name="metode"]:checked').value;
        let info = document.getElementById("infoMetode");

        if (metode === "dana") {
            info.style.display = "block";
            info.innerHTML = `
            <b>Bayar ke DANA:</b><br>
            Nomor: 0812-3456-7890<br>
            A/N: insaniar nurani
        `;
        } else if (metode === "transfer") {
            info.style.display = "block";
            info.innerHTML = `
            <b>Transfer Bank:</b><br>
            Bank BRI: 123-456-7890<br>
            A/N: insaniar nurani
        `;
        } else if (metode === "cod") {
            info.style.display = "block";
            info.innerHTML = `
            <b>COD:</b><br>
            Pembayaran dilakukan saat petugas datang.
        `;
        }
    }
</script>

<?= $this->endSection() ?>