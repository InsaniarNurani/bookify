<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Penerbit</h3>

<form action="<?= base_url('penerbit/store') ?>" method="post">

    Nama Penerbit:<br>
    <input type="text" name="nama_penerbit" required><br><br>

    Alamat:<br>
    <textarea name="alamat"></textarea><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('penerbit') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>