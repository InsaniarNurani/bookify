<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Transaksi</h3>

<form method="post" action="<?= base_url('transaksi/store') ?>">

    ID Peminjaman <br>
    <input type="text" name="id_peminjaman"><br><br>

    Jenis <br>
    <select name="jenis">
        <option value="denda">Denda</option>
        <option value="pengiriman">Pengiriman</option>
        <option value="penarikan">Penarikan</option>
    </select><br><br>

    Jumlah <br>
    <input type="number" name="jumlah"><br><br>

    <button type="submit">Simpan</button>

</form>

<?= $this->endSection() ?>