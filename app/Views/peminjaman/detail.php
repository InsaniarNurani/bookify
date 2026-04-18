<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    @media print {

        /* sembunyikan semua */
        body * {
            visibility: hidden;
        }

        /* tampilkan hanya area print */
        #area-print,
        #area-print * {
            visibility: visible;
        }

        /* posisikan ke atas */
        #area-print {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
        }

        /* hilangkan tombol */
        button,
        a {
            display: none;
        }
    }
</style>

<div id="area-print">

    <h3>Detail Peminjaman</h3>

    <table border="1" cellpadding="5">
        <tr>
            <td>Tanggal Pinjam</td>
            <td><?= $peminjaman['tanggal_pinjam'] ?></td>
        </tr>

        <tr>
            <td>Tanggal Kembali</td>
            <td><?= $peminjaman['tanggal_kembali'] ?></td>
        </tr>

        <tr>
            <td>Status</td>
            <td><?= $peminjaman['status'] ?></td>
        </tr>
    </table>

    <br>

    <h4>Buku yang Dipinjam</h4>

    <table border="1" cellpadding="5">
        <tr>
            <th>Judul Buku</th>
            <th>Jumlah</th>
        </tr>

        <tr>
            <td><?= implode(', ', array_column($detail, 'judul')) ?></td>
            <td><?= implode(', ', array_column($detail, 'jumlah')) ?></td>
        </tr>
    </table>

</div>

<br>

<button onclick="window.print()">Print</button>
<a href="<?= base_url('peminjaman') ?>">Kembali</a>

<?= $this->endSection() ?>