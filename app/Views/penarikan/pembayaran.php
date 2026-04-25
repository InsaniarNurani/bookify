<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pembayaran Penarikan</h3>

<div style="border:1px solid #ccc; padding:15px; border-radius:10px; margin-bottom:20px;">
    <h4>Detail Penarikan</h4>

    <p><b>ID Penarikan:</b> <?= $penarikan['id_penarikan'] ?></p>
    <p><b>ID Peminjaman:</b> <?= $penarikan['id_peminjaman'] ?></p>
    <p><b>Alamat:</b> <?= $penarikan['alamat'] ?></p>
    <p><b>Biaya:</b> Rp <?= number_format($penarikan['biaya'], 0, ',', '.') ?></p>
    <p><b>Status:</b> <?= $penarikan['status'] ?></p>
</div>

<?php if ($penarikan['status'] != 'lunas'): ?>
    <form action="<?= base_url('penarikan/prosesBayar/' . $penarikan['id_penarikan']) ?>" method="post">

        <div style="margin-bottom:10px;">
            <label>Metode Pembayaran</label><br>
            <select name="metode" required>
                <option value="">-- Pilih Metode --</option>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer Bank</option>
                <option value="ewallet">E-Wallet</option>
            </select>
        </div>

        <div style="margin-bottom:10px;">
            <label>Jumlah Bayar</label><br>
            <input type="number" name="jumlah_bayar" value="<?= $penarikan['biaya'] ?>" required>
        </div>

        <button type="submit" style="padding:8px 15px;">
            Bayar Sekarang
        </button>
    </form>
<?php else: ?>
    <p style="color:green;"><b>✔ Pembayaran sudah lunas</b></p>
<?php endif; ?>

<?= $this->endSection() ?>