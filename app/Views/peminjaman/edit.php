<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Peminjaman</h3>

<form method="post" action="<?= base_url('peminjaman/update/' . $peminjaman['id_peminjaman']) ?>">

    <label>Tanggal Pinjam</label><br>
    <input type="date" name="tanggal_pinjam"
        value="<?= $peminjaman['tanggal_pinjam'] ?>" required>
    <br><br>

    <label>Tanggal Kembali</label><br>
    <input type="date" name="tanggal_kembali"
        value="<?= $peminjaman['tanggal_kembali'] ?>" required>
    <br><br>

    <label>Status</label><br>
    <select name="status">
        <option value="dipinjam" <?= $peminjaman['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
        <option value="kembali" <?= $peminjaman['status'] == 'kembali' ? 'selected' : '' ?>>Kembali</option>
        <option value="terlambat" <?= $peminjaman['status'] == 'terlambat' ? 'selected' : '' ?>>Terlambat</option>
    </select>

    <br><br>

    <button type="submit">Simpan</button>

    <a href="<?= base_url('peminjaman') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>