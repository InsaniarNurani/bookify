<h2>Tambah Penarikan</h2>

<form action="/penarikan/store" method="post">
    <input type="text" name="id_peminjaman" placeholder="ID Peminjaman"><br>
    <textarea name="alamat" placeholder="Alamat"></textarea><br>
    <input type="number" name="biaya" placeholder="Biaya"><br>
    <input type="text" name="status" value="pending"><br>
    <input type="date" name="tanggal_ambil"><br>
    <input type="text" name="petugas_id"><br>

    <button type="submit">Simpan</button>
</form>