<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div id="printArea">

    <h3>Detail Peminjaman</h3>

    <!-- ✅ NAMA ANGGOTA (AMAN) -->
    <p><b>Nama Anggota:</b> <?= $peminjaman['nama_anggota'] ?? '-' ?></p>

    <!-- ✅ STATUS -->
    <p><b>Status:</b>
        <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>

            <?php if (($peminjaman['status_pengiriman'] ?? '') == 'menunggu_konfirmasi'): ?>
                <span style="color:orange; font-weight:bold;">Menunggu Konfirmasi</span>

            <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'menunggu_pembayaran'): ?>
                <span style="color:red; font-weight:bold;">Menunggu Pembayaran</span>

            <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'siap_dikirim'): ?>
                <span style="color:blue; font-weight:bold;">Siap Dikirim</span>

            <?php elseif (($peminjaman['status_pengiriman'] ?? '') == 'diantar'): ?>
                <span style="color:green; font-weight:bold;">Sedang Diantar</span>

            <?php else: ?>
                <span>-</span>
            <?php endif; ?>

        <?php else: ?>
            <span style="color:green;">
                <?= $peminjaman['status'] ?? '-' ?>
            </span>
        <?php endif; ?>
    </p>

    <!-- ✅ DATA LAIN -->
    <p><b>Tanggal Pinjam:</b> <?= $peminjaman['tanggal_pinjam'] ?? '-' ?></p>
    <p><b>Tanggal Kembali:</b> <?= $peminjaman['tanggal_kembali'] ?? '-' ?></p>
    <p><b>Metode:</b> <?= $peminjaman['metode_pengantaran'] ?? '-' ?></p>

    <?php if (($peminjaman['metode_pengantaran'] ?? '') == 'diantar'): ?>

        <p><b>Ongkir:</b> Rp <?= number_format($peminjaman['ongkir'] ?? 0, 0, ',', '.') ?></p>

        <p><b>Total Bayar:</b> Rp <?= number_format($peminjaman['total_bayar'] ?? 0, 0, ',', '.') ?></p>

    <?php else: ?>

        <p><b>Ongkir:</b> -</p>
        <p><b>Total Bayar:</b> -</p>

    <?php endif; ?>

    <!-- ✅ DENDA -->
    <p><b>Denda:</b>
        <?php if (!empty($peminjaman['denda']) && $peminjaman['denda'] > 0): ?>
            <span style="color:red;">
                Rp <?= number_format($peminjaman['denda'], 0, ',', '.') ?>
            </span>
        <?php else: ?>
            <span style="color:green;">Tidak ada denda</span>
        <?php endif; ?>
    </p>

    <hr>

    <h4>Detail Buku</h4>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>Judul</th>
            <th>Cover</th>
            <th>Jumlah Pinjam</th>
        </tr>

        <?php if (!empty($peminjaman['buku'])): ?>
            <?php foreach ($peminjaman['buku'] as $b): ?>
                <tr>
                    <td><?= $b['judul'] ?? '-' ?></td>
                    <td>
                        <img src="<?= base_url('uploads/buku/' . ($b['cover'] ?? 'default.png')) ?>" width="60">
                    </td>
                    <td><?= $b['jumlah'] ?? 1 ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" align="center">Tidak ada data buku</td>
            </tr>
        <?php endif; ?>
    </table>

</div>

<br>

<div class="no-print" style="margin-bottom:15px;">
    <a href="<?= base_url('peminjaman') ?>"
        style="padding:8px 12px; background:#ccc; text-decoration:none; border-radius:5px;">
        ⬅ Kembali
    </a>

    <button onclick="window.print()"
        style="padding:8px 12px; background:green; color:white; border:none; border-radius:5px;">
        🖨 Print
    </button>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #printArea,
        #printArea * {
            visibility: visible;
        }

        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .no-print {
            display: none !important;
        }
    }
</style>

<?= $this->endSection() ?>