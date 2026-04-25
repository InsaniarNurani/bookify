<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Transaksi</h3>

<hr>


<p><b>Nama Anggota:</b> <?= $transaksi['nama_anggota'] ?? '-' ?></p>

<p><b>Metode Pengantaran:</b> <?= $transaksi['metode_pengantaran'] ?? '-' ?></p>

<p><b>Metode Pembayaran:</b> <?= strtoupper($transaksi['metode_pembayaran'] ?? '-') ?></p>

<p><b>Ongkir:</b> Rp <?= number_format($transaksi['ongkir'] ?? 0, 0, ',', '.') ?></p>

<p><b>Total Bayar:</b> Rp <?= number_format($transaksi['total_bayar'] ?? 0, 0, ',', '.') ?></p>

<p>
    <b>Status:</b>
    <?= ($transaksi['status'] ?? '') == 'lunas'
        ? '<span style="color:green;">Lunas</span>'
        : '<span style="color:red;">Belum Bayar</span>' ?>
</p>

<p><b>Tanggal:</b> <?= $transaksi['tanggal'] ?? '-' ?></p>

<hr>

<!-- 🔥 BUKTI PEMBAYARAN -->
<?php if (!empty($transaksi['bukti_pembayaran'])): ?>
    <p><b>Bukti Pembayaran:</b></p>
    <img src="<?= base_url('uploads/bukti/' . $transaksi['bukti_pembayaran']) ?>" width="200">
<?php else: ?>
    <p><b>Bukti Pembayaran:</b> -</p>
<?php endif; ?>

<br><br>

<!-- 🔘 BUTTON -->
<a href="<?= base_url('transaksi') ?>"
    style="padding:8px 12px; background:#ccc; text-decoration:none; border-radius:5px;">
    ⬅ Kembali
</a>

<button onclick="window.print()"
    style="padding:8px 12px; background:green; color:white; border:none; border-radius:5px;">
    🖨 Print
</button>

<!-- 🖨 STYLE PRINT -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        body {
            margin: 0;
        }

        .content,
        .content * {
            visibility: visible;
        }
    }
</style>

<?= $this->endSection() ?>