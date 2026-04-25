<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>


<h2>Tambah Penarikan</h2>



<form action="<?= base_url('penarikan/store') ?>" method="post">

    ID Peminjaman <br>
    <input type="text" name="id_peminjaman"
        value="<?= $id_peminjaman ?? '' ?>" readonly><br><br>

    Alamat <br>
    <textarea name="alamat"></textarea><br><br>

    Biaya <br>
    <input type="text" name="biaya"><br><br>

    Tanggal Ambil <br>
    <input type="date" name="tanggal_ambil"><br><br>

    Petugas ID <br>
    <input type="text" name="petugas_id"><br><br>

    <button type="submit">Simpan Penarikan</button>

</form>
<?= $this->endSection() ?>