<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Pinjam Buku</h3>

<?php if (session()->getFlashdata('error')): ?>
    <div style="color:red;">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= base_url('peminjaman/store') ?>">

    <!-- ================= USER ================= -->
    <label>Nama Peminjam</label><br>
    <input type="text" value="<?= session()->get('nama') ?>" readonly>

    <input type="hidden" name="id_anggota" value="<?= session()->get('id_anggota') ?>">

    <br><br>

    <!-- ================= METODE ================= -->
    <label>Metode Pengambilan</label><br>
    <select name="metode" id="metode" required>
        <option value="">-- Pilih --</option>
        <option value="ambil">Ambil di Perpustakaan</option>
        <option value="antar">Kirim ke Rumah</option>
    </select>

    <br><br>
    <label>Tanggal Pinjam</label><br>
    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required>

    <br><br>

    <label>Tanggal Kembali (otomatis 7 hari)</label><br>
    <input type="date" name="tanggal_kembali" id="tanggal_kembali" readonly>
    <br><br>

    <!-- ================= ALAMAT ================= -->
    <div id="alamatBox" style="display:none;">
        <label>Alamat Pengiriman</label><br>
        <textarea name="alamat" id="alamatInput" placeholder="Masukkan alamat lengkap"></textarea>
    </div>

    <br><br>

    <!-- ================= LIST BUKU ================= -->
    <div style="display:flex; flex-wrap:wrap; gap:20px;">

        <?php foreach ($buku as $b): ?>
            <div style="border:1px solid #ccc; padding:10px; width:180px; text-align:center;">

                <!-- COVER -->
                <?php if (!empty($b['cover'])): ?>
                    <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>" width="120">
                <?php else: ?>
                    <div style="width:120px;height:160px;background:#eee;line-height:160px;">
                        No Cover
                    </div>
                <?php endif; ?>

                <br><br>

                <!-- JUDUL -->
                <b><?= $b['judul'] ?></b>

                <br>

                <!-- ================= FIX DI SINI ================= -->
                Stok: <?= $b['jumlah'] ?>

                <br><br>

                <!-- PILIH BUKU -->
                <?php if ($b['jumlah'] > 0): ?>
                    <label>
                        <input type="checkbox" class="pilihBuku" name="buku[]" value="<?= $b['id_buku'] ?>">
                        Pilih
                    </label>
                <?php else: ?>
                    <span style="color:red;">Stok Habis</span>
                <?php endif; ?>

                <br><br>

                <!-- DETAIL -->
                <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>">Detail</a>

            </div>
        <?php endforeach; ?>

    </div>

    <br><br>

    <!-- ================= SUBMIT ================= -->
    <button type="submit">Pinjam Buku</button>
    <br><br>

    <a href="<?= base_url('peminjaman') ?>"
        style="padding:8px 12px; background:#444; color:white; text-decoration:none; border-radius:5px;">
        ⬅ Kembali ke Data Peminjaman
    </a>

</form>

<!-- ================= JAVASCRIPT ================= -->
<script>
    // ===== MAX 2 BUKU =====
    let checkboxes = document.querySelectorAll('.pilihBuku');

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            let checked = document.querySelectorAll('.pilihBuku:checked');

            if (checked.length > 2) {
                alert('Maksimal pinjam 2 buku!');
                this.checked = false;
            }
        });
    });
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        let pinjam = new Date(this.value);

        if (!isNaN(pinjam)) {
            let kembali = new Date(pinjam);
            kembali.setDate(kembali.getDate() + 7); // 7 hari pinjam

            let yyyy = kembali.getFullYear();
            let mm = String(kembali.getMonth() + 1).padStart(2, '0');
            let dd = String(kembali.getDate()).padStart(2, '0');

            document.getElementById('tanggal_kembali').value = `${yyyy}-${mm}-${dd}`;
        }
    });
    // ===== SHOW ALAMAT =====
    document.getElementById('metode').addEventListener('change', function() {
        let alamatBox = document.getElementById('alamatBox');

        if (this.value === 'antar') {
            alamatBox.style.display = 'block';
        } else {
            alamatBox.style.display = 'none';
        }
    });

    // ===== VALIDASI FORM =====
    document.querySelector('form').addEventListener('submit', function(e) {

        let checked = document.querySelectorAll('.pilihBuku:checked');
        let metode = document.getElementById('metode').value;
        let alamat = document.getElementById('alamatInput').value;

        if (checked.length == 0) {
            alert('Pilih minimal 1 buku!');
            e.preventDefault();
            return;
        }

        if (checked.length > 2) {
            alert('Maksimal 2 buku!');
            e.preventDefault();
            return;
        }

        if (metode === '') {
            alert('Pilih metode pengambilan!');
            e.preventDefault();
            return;
        }

        if (metode === 'antar' && alamat === '') {
            alert('Alamat wajib diisi untuk pengiriman!');
            e.preventDefault();
            return;
        }

    });
</script>


<?= $this->endSection() ?>