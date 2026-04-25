<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pembayaran Ongkir</h3>

<h4>Rincian Pembayaran</h4>

<?php $ongkir = 10000; ?>
<?php $total = ($total ?? 0) + $ongkir; ?>

<p><b>Ongkir:</b> Rp <?= number_format($ongkir, 0, ',', '.') ?></p>
<p><b>Total Bayar:</b> Rp <?= number_format($total, 0, ',', '.') ?></p>
<hr>

<form method="post" action="<?= base_url('peminjaman/bayar/' . $id) ?>" enctype="multipart/form-data">

    <p><b>Pilih Metode Pembayaran:</b></p>

    <label>
        <input type="radio" name="metode" value="dana" required>
        DANA
    </label><br>

    <label>
        <input type="radio" name="metode" value="transfer">
        Transfer Bank
    </label><br>

    <label>
        <input type="radio" name="metode" value="cod">
        COD (Bayar di Tempat)
    </label>

    <br><br>

    <p><b>Upload Bukti (WAJIB jika transfer/DANA):</b></p>
    <input type="file" name="bukti" accept="image/*">

    <br><br>

    <button type="submit" style="padding:10px 20px;background:black;color:white;">
        Konfirmasi Pembayaran
    </button>

</form>


<?= $this->endSection() ?>