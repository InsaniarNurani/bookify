<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Kategori</h3>

<!-- Tombol Tambah -->
<a href="<?= base_url('kategori/create') ?>">+ Tambah Kategori</a>

<br><br>

<!-- Tabel -->
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($kategori as $k): ?>
        <tr>
            <td><?= $k['id_kategori'] ?></td>
            <td><?= $k['nama_kategori'] ?></td>
            <td>

                <a href="<?= base_url('kategori/edit/' . $k['id_kategori']) ?>">
                    Edit
                </a>

                |

                <a href="<?= base_url('kategori/delete/' . $k['id_kategori']) ?>"
                    onclick="return confirm('Yakin mau hapus kategori ini?')">
                    Hapus
                </a>

            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>