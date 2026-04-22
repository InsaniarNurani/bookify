<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Detail Peminjaman</h3>

<table border="1" cellpadding="8">

    <tr>
        <th>ID Peminjaman</th>
        <td><?= $peminjaman['id_peminjaman'] ?></td>
    </tr>

    <tr>
        <th>Anggota</th>
        <td><?= $peminjaman['user_id'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Petugas</th>
        <td><?= $peminjaman['nama_petugas'] ?? '-' ?></td>
    </tr>

    <tr>
        <th>Tanggal Pinjam</th>
        <td><?= $peminjaman['tanggal_pinjam'] ?></td>
    </tr>

    <tr>
        <th>Tanggal Kembali</th>
        <td><?= $peminjaman['tanggal_kembali'] ?></td>
    </tr>

    <tr>
        <th>Status</th>
        <td><?= $peminjaman['status'] ?></td>
    </tr>

</table>

<br>

<a href="<?= base_url('peminjaman') ?>">⬅ Kembali</a>

<?= $this->endSection() ?>