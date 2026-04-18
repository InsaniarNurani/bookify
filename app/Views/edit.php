<h3>Edit Anggota</h3>

<form method="post" action="<?= base_url('anggota/update/' . $anggota['id_anggota']) ?>">

    User ID:
    <input type="number" name="user_id" value="<?= $anggota['user_id'] ?>"><br><br>

    NIS:
    <input type="text" name="nis" value="<?= $anggota['nis'] ?>"><br><br>

    Alamat:
    <textarea name="alamat"><?= $anggota['alamat'] ?></textarea><br><br>

    No HP:
    <input type="text" name="no_hp" value="<?= $anggota['no_hp'] ?>"><br><br>

    Tanggal Daftar:
    <input type="date" name="tanggal_daftar" value="<?= $anggota['tanggal_daftar'] ?>"><br><br>

    <button type="submit">Update</button>
</form>