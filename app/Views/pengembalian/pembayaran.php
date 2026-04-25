<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pembayaran Denda</h3>

<hr>

<!-- 🔥 INFO DATA -->
<p><b>ID Pengembalian:</b> <?= $pengembalian['id_pengembalian'] ?></p>
<p><b>Nama Anggota:</b> <?= $pengembalian['nama_anggota'] ?? '-' ?></p>

<p><b>Total Denda:</b>
    <span style="color:red; font-weight:bold;">
        Rp <?= number_format($pengembalian['denda'] ?? 0, 0, ',', '.') ?>
    </span>
</p>

<hr>

<!-- 🔥 FORM BAYAR -->
<form method="post" action="<?= base_url('pengembalian/prosesBayar/' . $pengembalian['id_pengembalian']) ?>" enctype="multipart/form-data">

    <p><b>Pilih Metode Pembayaran:</b></p>

    <label>
        <input type="radio" name="metode" value="transfer" required>
        Transfer
    </label><br>

    <label>
        <input type="radio" name="metode" value="cod">
        COD (Bayar di Tempat)
    </label>

    <br><br>

    <p><b>Upload Bukti (WAJIB jika Transfer):</b></p>
    <input type="file" name="bukti" accept="image/*">

    <br><br>

    <button type="submit"
        style="padding:10px 20px; background:black; color:white; border:none; border-radius:5px;">
        💳 Bayar Sekarang
    </button>

</form>

<br>

<a href="<?= base_url('pengembalian') ?>"
    style="padding:8px 12px; background:#ccc; text-decoration:none; border-radius:5px;">
    ⬅ Kembali
</a>

<?= $this->endSection() ?>