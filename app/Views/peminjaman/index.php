<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Peminjaman</h3>

<a href="<?= base_url('peminjaman/create') ?>">
    <button>+ Tambah</button>
</a>

<br><br>

<table border="1" cellpadding="8">

    <tr>
        <th>ID</th>
        <th>Anggota</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($peminjaman as $p): ?>
        <tr>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['nama'] ?? '-' ?></td>
            <td><?= $p['tanggal_pinjam'] ?? '-' ?></td>
            <td><?= $p['tanggal_kembali'] ?? '-' ?></td>
            <td><?= $p['status'] ?></td>

            <td>
                <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>">Detail</a> |
                <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']) ?>">Edit</a>
                <a href="<?= base_url('peminjaman/perpanjang/' . $p['id_peminjaman']) ?>"
                    onclick="return confirm('Perpanjang peminjaman?')">
                    Perpanjang
                </a> |

                <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>"
                    onclick="return confirm('Kembalikan buku?')">
                    Kembalikan
                </a> |

                <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>">
                    Hapus
                </a>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<?= $this->endSection() ?>