<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pembayaran Ongkir</h3>

<?php
$ongkir = 10000;
$total = ($total ?? 0) + $ongkir;
?>

<p><b>Ongkir:</b> Rp <?= number_format($ongkir, 0, ',', '.') ?></p>
<p><b>Total Bayar:</b> Rp <?= number_format($total, 0, ',', '.') ?></p>

<hr>

<form method="post" action="<?= base_url('peminjaman/bayar/' . $id) ?>" enctype="multipart/form-data">

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

    <!-- 🔵 INFO DINAMIS -->
    <div id="infoMetode" style="padding:10px;border:1px solid #ccc;display:none;"></div>

    <br>

    <p><b>Upload Bukti (WAJIB jika transfer/DANA):</b></p>
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
            Atas nama: insaniar nurani 

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
            Pembayaran dilakukan saat buku diantar.
        `;
        }
    }
</script>

<?= $this->endSection() ?>