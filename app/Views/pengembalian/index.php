<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Pengembalian</h3>



<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID Pengembalian</th>
        <th>ID Peminjaman</th>
        <th>Nama Anggota</th>
        <th>Petugas</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Dikembalikan</th>
        <th>Denda</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($pengembalian as $p): ?>
        <tr>
            <td><?= $p['id_pengembalian'] ?></td>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['nama_anggota'] ?? '-' ?></td>
            <td><?= $p['jabatan'] ?? '-' ?></td>
            <td><?= $p['tanggal_pinjam'] ?? '-' ?></td>
            <td><?= $p['tanggal_dikembalikan'] ?></td>
            <td><?= $p['denda'] ?></td>

            <td>
                <a href="<?= base_url('pengembalian/detail/' . $p['id_pengembalian']) ?>">Detail</a>
                <a href="<?= base_url('pengembalian/edit/' . $p['id_pengembalian']) ?>">Edit</a>
                <a href="<?= base_url('pengembalian/delete/' . $p['id_pengembalian']) ?>"
                    onclick="return confirm('Hapus data?')">
                    Hapus
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>