<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Anggota</h3>

<form method="post" action="<?= base_url('anggota/store') ?>">

    User:
    <select name="user_id" required>
        <option value="">-- Pilih User --</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user['id'] ?>"><?= $user['nama'] ?> (<?= $user['username'] ?>)</option>
        <?php endforeach; ?>
    </select>
    <br><br>

    NIS:
    <input type="text" name="nis" required><br><br>

    Alamat:
    <textarea name="alamat" required></textarea><br><br>

    No HP:
    <input type="text" name="no_hp" required><br><br>

    Tanggal Daftar:
    <input type="date" name="tanggal_daftar" value="<?= date('Y-m-d') ?>" required><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('Anggota') ?>">Kembali</a>

</form>
<?= $this->endSection() ?>