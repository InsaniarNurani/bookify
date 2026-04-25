<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h3>Tambah Buku</h3>

<form method="post" action="<?= base_url('buku/store') ?>" enctype="multipart/form-data">

    Judul:<br>
    <input type="text" name="judul"><br><br>

    ISBN:<br>
    <input type="text" name="isbn"><br><br>

    Kategori:<br>
    <select name="id_kategori" id="kategori" class="form-control">
        <option value="">Pilih Kategori</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id_kategori'] ?>">
                <?= $k['nama_kategori'] ?>
            </option>
        <?php endforeach; ?>
        <option value="new">+ Tambah Kategori Baru</option>
    </select>

    <input type="text" name="kategori_baru" id="kategori_baru"
        placeholder="Tulis kategori baru"
        style="display:none; margin-top:10px;">
    <br><br>

    Penulis:<br>
    <select name="id_penulis" id="penulis" class="form-control">
        <option value="">Pilih Penulis</option>
        <?php foreach ($penulis as $p): ?>
            <option value="<?= $p['id_penulis'] ?>">
                <?= $p['nama_penulis'] ?>
            </option>
        <?php endforeach; ?>
        <option value="new">+ Tambah Penulis Baru</option>
    </select>

    <input type="text" name="penulis_baru" id="penulis_baru"
        placeholder="Tulis penulis baru"
        style="display:none; margin-top:10px;">
    <br><br>
    Penerbit:<br>
    <select name="id_penerbit" id="penerbit" class="form-control">
        <option value="">Pilih Penerbit</option>
        <?php foreach ($penerbit as $p): ?>
            <option value="<?= $p['id_penerbit'] ?>">
                <?= $p['nama_penerbit'] ?>
            </option>
        <?php endforeach; ?>
        <option value="new">+ Tambah Penerbit Baru</option>
    </select>

    <input type="text" name="penerbit_baru" id="penerbit_baru"
        placeholder="Tulis penerbit baru"
        style="display:none; margin-top:10px;">
    <br><br>
    Rak:<br>
    <select name="id_rak">
        <option value="">Pilih</option>
        <?php foreach ($rak as $r): ?>
            <option value="<?= $r['id_rak'] ?>">
                <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    Tahun Terbit:<br>
    <input type="number" name="tahun_terbit"><br><br>

    Jumlah:<br>
    <input type="number" name="jumlah"><br><br>

    Tersedia:<br>
    <input type="number" name="tersedia"><br><br>

    Deskripsi:<br>
    <textarea name="deskripsi"></textarea><br><br>

    Cover :<br>
    <input type="file" name="cover"><br><br>

    <button type="submit">Simpan</button>
    <a href="<?= base_url('buku') ?>">Kembali</a>

</form>
<script>
    document.getElementById('kategori').addEventListener('change', function() {
        let input = document.getElementById('kategori_baru');
        if (this.value === 'new') {
            input.style.display = 'block';
        } else {
            input.style.display = 'none';
        }
    });
</script>
<script>
    document.getElementById('penulis').addEventListener('change', function() {
        document.getElementById('penulis_baru').style.display =
            (this.value === 'new') ? 'block' : 'none';
    });

    document.getElementById('penerbit').addEventListener('change', function() {
        document.getElementById('penerbit_baru').style.display =
            (this.value === 'new') ? 'block' : 'none';
    });
</script>
<?= $this->endSection() ?>