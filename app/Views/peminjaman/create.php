<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Tambah Peminjaman</h3>

<form method="post" action="<?= base_url('peminjaman/store') ?>">

    <!-- 🔹 ATAS (2 KOLOM) -->
    <div style="display:flex; gap:30px;">

        <!-- KIRI -->
        <div style="flex:1;">
            <p>Nama Anggota:
                <b><?= session()->get('nama') ?></b>
            </p>

            <p>Tanggal Pinjam: <b><?= date('Y-m-d') ?></b></p>
            <p>Tanggal Kembali: <b><?= date('Y-m-d', strtotime('+7 days')) ?></b></p>
        </div>

        <!-- KANAN -->
        <div style="flex:1;">
            <p>Metode Pengantaran:</p>
            <select name="metode_pengantaran" id="metode">
                <option value="ambil">Ambil di Perpustakaan</option>
                <option value="diantar">Diantar ke Rumah</option>
            </select>

            <div id="alamatBox" style="display:none; margin-top:10px;">
                <p>Alamat:</p>
                <textarea name="alamat"></textarea>
            </div>


        </div>

    </div>

    <hr>

    <!-- 🔻 BUKU DI BAWAH (FULL WIDTH) -->
    <p><b>Pilih Buku (max 2)</b></p>

    <div style="display:flex; flex-wrap:wrap; gap:15px;">
        <?php foreach ($buku as $b): ?>
            <label style="width:200px; border:1px solid #ccc; padding:10px; text-align:center; border-radius:8px;">

                <!-- checkbox -->
                <input type="checkbox"
                    name="id_buku[]"
                    value="<?= $b['id_buku'] ?>"
                    class="buku-check"
                    <?= ($b['tersedia'] ?? 0) <= 0 ? 'disabled' : '' ?>><br>

                <!-- cover -->
                <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="80"><br>

                <!-- judul -->
                <b><?= $b['judul'] ?></b><br>

                <!-- stok -->
                <?php if (($b['tersedia'] ?? 0) > 0): ?>
                    <small style="color:green;">
                        Tersedia: <?= $b['tersedia'] ?>
                    </small>
                <?php else: ?>
                    <small style="color:red;">
                        Stok Habis
                    </small>
                <?php endif; ?>

            </label>
        <?php endforeach; ?>
    </div>

    <br>
    <button type="submit">Simpan</button>

</form>

<!-- SCRIPT -->
<script>
    // tampil alamat
    const metode = document.getElementById('metode');
    const alamatBox = document.getElementById('alamatBox');

    metode.addEventListener('change', function() {
        alamatBox.style.display = (this.value === 'diantar') ? 'block' : 'none';
    });

    // max 2 buku
    const checkboxes = document.querySelectorAll('.buku-check');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            let checked = document.querySelectorAll('.buku-check:checked');
            if (checked.length > 2) {
                alert('Maksimal 2 buku!');
                this.checked = false;
            }
        });
    });
</script>

<?= $this->endSection() ?>