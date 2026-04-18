<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Anggota</h3>

<form method="post" action="<?= base_url('anggota/store') ?>" method="post">

    User ID:
    <input type="number" name="user_id"><br><br>

    NIS:
    <input type="text" name="nis"><br><br>

    Alamat:
    <textarea name="alamat"></textarea><br><br>

    No HP:
    <input type="text" name="no_hp"><br><br>

    Tanggal Daftar:
    <input type="date" name="tanggal_daftar"><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('Anggota') ?>">Kembali</a>

</form>
<?= $this->endSection() ?>