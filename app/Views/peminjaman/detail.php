<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<!-- 🔥 PRINT AREA START -->
<div id="printArea">

    <h3>Detail Peminjaman</h3>

    <p><b>Status:</b> <?= $peminjaman['status'] ?></p>
    <p><b>Tanggal Pinjam:</b> <?= $peminjaman['tanggal_pinjam'] ?></p>
    <p><b>Tanggal Kembali:</b> <?= $peminjaman['tanggal_kembali'] ?></p>
    <p><b>Metode:</b> <?= $peminjaman['metode_pengantaran'] ?></p>

    <hr>

    <h4>Detail Buku</h4>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>Judul</th>
            <th>Cover</th>

            <th>Jumlah Pinjam</th>
        </tr>

        <?php foreach ($peminjaman['buku'] as $b): ?>
            <tr>
                <td><?= $b['judul'] ?></td>
                <td>
                    <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="60">
                </td>

                <td>
                    <?= $b['jumlah'] ?? 1 ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
<!-- 🔥 PRINT AREA END -->

<br>

<!-- 🔘 BUTTON ACTION -->
<div class="no-print" style="margin-bottom:15px;">

    <a href="<?= base_url('peminjaman') ?>"
        style="padding:8px 12px; background:#ccc; text-decoration:none; border-radius:5px;">
        ⬅ Kembali
    </a>

    <button onclick="window.print()"
        style="padding:8px 12px; background:green; color:white; border:none; border-radius:5px; margin-left:10px;">
        🖨 Print
    </button>

</div>

<!-- 🎯 PRINT STYLE -->
<style>
    @media print {

        /* sembunyikan semua */
        body * {
            visibility: hidden;
        }

        /* tampilkan hanya area ini */
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

        /* tombol & link tidak ikut */
        .no-print {
            display: none !important;
        }
    }
</style>

<?= $this->endSection() ?>