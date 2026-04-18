<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Edit Rak</h3>

<form action="<?= base_url('rak/update/' . $rak['id_rak']) ?>" method="post">

    Nama Rak:<br>
    <input type="text" name="nama_rak"
        value="<?= $rak['nama_rak'] ?>" required><br><br>

    Lokasi:<br>
    <input type="text" name="lokasi"
        value="<?= $rak['lokasi'] ?>"><br><br>

    <button type="submit">Update</button>
    <a href="<?= base_url('rak') ?>">Kembali</a>

</form>

<?= $this->endSection() ?>