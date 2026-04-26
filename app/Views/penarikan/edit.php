<h2>Edit Penarikan</h2>

<form action="/penarikan/update/<?= $penarikan['id_penarikan'] ?>" method="post">
    <input type="text" name="id_peminjaman" value="<?= $penarikan['id_peminjaman'] ?>"><br>
    <textarea name="alamat"><?= $penarikan['alamat'] ?></textarea><br>
    <input type="number" name="biaya" value="<?= $penarikan['biaya'] ?>"><br>
    <input type="text" name="status" value="<?= $penarikan['status'] ?>"><br>
    <input type="date" name="tanggal_ambil" value="<?= $penarikan['tanggal_ambil'] ?>"><br>
    <input type="text" name="petugas_id" value="<?= $penarikan['petugas_id'] ?>"><br>

    <button type="submit">Update</button>
</form>