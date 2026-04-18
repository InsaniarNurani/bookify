<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Penulis</h3>

<a href="<?= base_url('penulis/create') ?>">+ Tambah Penulis</a>

<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Penulis</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($penulis as $p): ?>
        <tr>
            <td><?= $p['id_penulis'] ?></td>
            <td><?= $p['nama_penulis'] ?></td>
            <td>
                <a href="<?= base_url('penulis/edit/' . $p['id_penulis']) ?>">Edit</a>
                |
                <a href="<?= base_url('penulis/delete/' . $p['id_penulis']) ?>"
                    onclick="return confirm('Hapus data ini?')">
                    Hapus
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>