<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pembayaran Ongkir</h3>

<p><b>ID Peminjaman:</b> <?= $peminjaman['id_peminjaman'] ?></p>

<h4>Total Ongkir: Rp <?= number_format($ongkir, 0, ',', '.') ?></h4>

<hr>

<form method="post" action="<?= base_url('peminjaman/prosesBayar/' . $peminjaman['id_peminjaman']) ?>">

    <!-- PILIH METODE -->
    <label><b>Pilih Metode Pembayaran</b></label><br><br>

    <select name="metode" required>
        <option value="">-- Pilih --</option>
        <option value="dana">DANA</option>
        <option value="transfer">cash</option>
    </select>

    <br><br>

    <!-- QR SECTION -->
    <div style="display:flex; justify-content:flex-start; gap:40px; margin-top:20px;">

        <!-- DANA -->
        <div>
            <p><b>DANA</b></p>
            <img src="<?= base_url('uploads/qr/dana.png') ?>" width="180">
            <p>Scan untuk bayar DANA</p>
        </div>


        <!-- UPLOAD BUKTI -->
        <label><b>Upload Bukti Pembayaran</b></label><br><br>
        <input type="file" name="bukti" accept="image/*" required>

    </div>

    <br><br>

    <!-- BUTTON -->
    <button type="submit" style="background:green;color:white;padding:10px 15px;">
        Bayar Sekarang
    </button>

</form>

<?= $this->endSection() ?>