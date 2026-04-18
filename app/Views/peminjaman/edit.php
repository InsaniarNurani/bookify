<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h4>Edit Peminjaman</h4>

<form action="<?= base_url('peminjaman/update/' . $peminjaman['id_peminjaman']) ?>" method="post">

    <!-- ANGGOTA -->
    <label>Anggota</label><br>
    <select name="id_anggota" required>
        <?php foreach ($anggota as $a): ?>
            <option value="<?= $a['id_anggota'] ?>"
                <?= $a['id_anggota'] == $peminjaman['id_anggota'] ? 'selected' : '' ?>>
                <?= $a['nama'] ?? $a['user_id'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- PETUGAS -->
    <label>Petugas</label><br>
    <select name="id_petugas" required>
        <?php foreach ($petugas as $p): ?>
            <option value="<?= $p['id_petugas'] ?>"
                <?= $p['id_petugas'] == $peminjaman['id_petugas'] ? 'selected' : '' ?>>
                <?= $p['jabatan'] ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- TANGGAL PINJAM -->
    <label>Tanggal Pinjam</label><br>
    <input type="date" name="tanggal_pinjam"
        value="<?= $peminjaman['tanggal_pinjam'] ?>" required>
    <br><br>



    <!-- STATUS -->
    <label>Status</label><br>
    <select name="status">
        <option value="dipinjam" <?= $peminjaman['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
        <option value="kembali" <?= $peminjaman['status'] == 'kembali' ? 'selected' : '' ?>>Kembali</option>
        <option value="terlambat" <?= $peminjaman['status'] == 'terlambat' ? 'selected' : '' ?>>Terlambat</option>
    </select>

    <br><br>

    <button type="submit">Update</button>
    <a href="<?= base_url('peminjaman') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>