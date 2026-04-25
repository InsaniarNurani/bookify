<h2>Edit Penarikan</h2>

<form action="<?= base_url('penarikan/update/' . $penarikan['id_penarikan']) ?>" method="post">

    ID Peminjaman <br>
    <input type="text" name="id_peminjaman" value="<?= $penarikan['id_peminjaman'] ?>"><br><br>

    Alamat <br>
    <textarea name="alamat"><?= $penarikan['alamat'] ?></textarea><br><br>

    Biaya <br>
    <input type="text" name="biaya" value="<?= $penarikan['biaya'] ?>"><br><br>

    Status <br>
    <select name="status">
        <option value="menunggu" <?= $penarikan['status'] == 'menunggu' ? 'selected' : '' ?>>menunggu</option>
        <option value="diproses" <?= $penarikan['status'] == 'diproses' ? 'selected' : '' ?>>diproses</option>
        <option value="diambil" <?= $penarikan['status'] == 'diambil' ? 'selected' : '' ?>>diambil</option>
        <option value="selesai" <?= $penarikan['status'] == 'selesai' ? 'selected' : '' ?>>selesai</option>
    </select><br><br>

    Tanggal Ambil <br>
    <input type="date" name="tanggal_ambil" value="<?= $penarikan['tanggal_ambil'] ?>"><br><br>

    Petugas ID <br>
    <input type="text" name="petugas_id" value="<?= $penarikan['petugas_id'] ?>"><br><br>

    <button type="submit">Update</button>

</form>