<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Pengembalian</h3>

<table border="1">
    <tr>
        <td>ID</td>
        <td><?= $pengembalian['id_pengembalian'] ?></td>
    </tr>
    <tr>
        <td>ID Peminjaman</td>
        <td><?= $pengembalian['id_peminjaman'] ?></td>
    </tr>
    <tr>
        <td>Tanggal Dikembalikan</td>
        <td><?= $pengembalian['tanggal_dikembalikan'] ?></td>
    </tr>
    <tr>
        <td>Denda</td>
        <td><?= $pengembalian['denda'] ?></td>
    </tr>
</table>

<a href="<?= base_url('pengembalian') ?>">Kembali</a>
<?= $this->endSection() ?>