<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Rak</h3>

<!-- Tombol Tambah -->
<?php if (session()->get('role') == 'admin') : ?>
    <a href="<?= base_url('rak/create') ?>">+ Tambah Rak</a>
<?php endif; ?>

<br><br>

<!-- Tabel -->
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Rak</th>
        <th>Lokasi</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($rak as $r): ?>
        <tr>
            <td><?= $r['id_rak'] ?></td>
            <td><?= $r['nama_rak'] ?></td>
            <td><?= $r['lokasi'] ?></td>
            <td>

                <?php if (session()->get('role') == 'admin') : ?>
                    <a href="<?= base_url('rak/edit/' . $r['id_rak']) ?>">Edit</a>
                    |
                    <a href="<?= base_url('rak/delete/' . $r['id_rak']) ?>"
                        onclick="return confirm('Yakin mau hapus rak ini?')">
                        Hapus
                    </a>
                <?php endif; ?>

            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>