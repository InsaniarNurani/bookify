<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Data Peminjaman</h3>

<a href="<?= base_url('peminjaman/create') ?>">+ Tambah Peminjaman</a>

<br><br>
<!-- FORM PENCARIAN & FILTER -->
<form method="get" action="">

    <input type="text"
        name="keyword"
        placeholder="Cari nama anggota..."
        value="<?= $_GET['keyword'] ?? '' ?>">

    <select name="status">
        <option value="">-- Semua Status --</option>
        <option value="dipinjam" <?= (($_GET['status'] ?? '') == 'dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
        <option value="kembali" <?= (($_GET['status'] ?? '') == 'kembali') ? 'selected' : '' ?>>Kembali</option>
        <option value="terlambat" <?= (($_GET['status'] ?? '') == 'terlambat') ? 'selected' : '' ?>>Terlambat</option>
    </select>

    <button type="submit">Cari</button>

    <a href="<?= base_url('peminjaman') ?>">Reset</a>

</form>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Anggota</th>
        <th>Petugas</th>
        <th>Tgl Pinjam</th>
        <th>Tgl Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php foreach ($peminjaman as $p): ?>
        <tr>
            <td><?= $p['id_peminjaman'] ?></td>
            <td><?= $p['nama_anggota'] ?></td>
            <td><?= $p['jabatan'] ?></td>
            <td><?= $p['tanggal_pinjam'] ?></td>
            <td><?= $p['tanggal_kembali'] ?></td>
            <td>
                <?php if ($p['status'] == 'dipinjam'): ?>
                    <span style="color: orange; font-weight: bold;">Dipinjam</span>

                <?php elseif ($p['status'] == 'kembali'): ?>
                    <span style="color: green; font-weight: bold;">Kembali</span>

                <?php elseif ($p['status'] == 'terlambat'): ?>
                    <span style="color: red; font-weight: bold;">Terlambat</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="<?= base_url('peminjaman/detail/' . $p['id_peminjaman']) ?>">Detail</a>
                <a href="<?= base_url('peminjaman/edit/' . $p['id_peminjaman']) ?>">Edit</a>
                <a href="<?= base_url('peminjaman/kembalikan/' . $p['id_peminjaman']) ?>">Kembalikan</a>
                <a href="<?= base_url('peminjaman/delete/' . $p['id_peminjaman']) ?>"
                    onclick="return confirm('Hapus data?')">
                    Hapus
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>