<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<a href="<?= base_url('anggota') ?>">Data Anggota</a>
<br><br>

<form method="get">
    <input type="text" name="keyword" placeholder="Cari..." value="<?= $_GET['keyword'] ?? '' ?>">
    <button type="submit">Cari</button>
    <a href="<?= base_url('anggota') ?>">Reset</a>
</form>

<br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>NIS</th>
        <th>Alamat</th>
        <th>No HP</th>
        <th>Tanggal Daftar</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($anggota as $a): ?>
        <tr>
            <td><?= $a['id_anggota'] ?></td>
            <td><?= $a['user_id'] ?></td>
            <td><?= $a['nis'] ?></td>
            <td><?= $a['alamat'] ?></td>
            <td><?= $a['no_hp'] ?></td>
            <td><?= $a['tanggal_daftar'] ?></td>
            <td>
                <a href="<?= base_url('anggota/edit/' . $a['id_anggota']) ?>">Edit</a>
                <a href="<?= base_url('anggota/delete/' . $a['id_anggota']) ?>" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>