<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h3 class="mb-4">📚 Tambah Peminjaman</h3>

    <!-- ================== SEARCH ================== -->
    <form method="get" action="<?= base_url('peminjaman/create') ?>" class="mb-3">
        <div class="input-group">
            <input type="text"
                name="keyword"
                class="form-control"
                placeholder="Cari judul buku..."
                value="<?= $keyword ?? '' ?>">

            <button class="btn btn-primary">🔍 Cari</button>
        </div>
    </form>

    <?php $keranjang = session()->get('keranjang') ?? []; ?>

    <!-- ================== LIST BUKU ================== -->
    <div class="row">
        <?php foreach ($buku as $b): ?>

            <?php
            $jumlahDipilih = 0;
            foreach ($keranjang as $k) {
                if ($k['id_buku'] == $b['id_buku']) {
                    $jumlahDipilih = $k['jumlah'];
                }
            }
            ?>

            <div class="col-md-3 mb-4">

                <div class="card shadow-sm h-100 border-0 position-relative"
                    style="border-radius:10px; overflow:hidden;">

                    <!-- COVER RAPI (tidak kepotong, tidak terlalu besar) -->
                    <div style="height:200px; display:flex; align-items:center; justify-content:center; background:#f8f9fa;">
                        <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>"
                            style="max-height:100%; max-width:100%; object-fit:contain;">
                    </div>

                    <!-- BADGE KERANJANG -->
                    <?php if ($jumlahDipilih > 0): ?>
                        <span style="
                            position:absolute;
                            top:10px;
                            right:10px;
                            background:red;
                            color:white;
                            padding:5px 10px;
                            border-radius:50%;
                            font-size:12px;">
                            <?= $jumlahDipilih ?>
                        </span>
                    <?php endif; ?>

                    <div class="card-body text-center">

                        <h6 class="mb-2"><?= $b['judul'] ?></h6>

                        <small class="text-muted">
                            Stok: <?= $b['tersedia'] ?>
                        </small>

                        <div class="d-flex justify-content-center gap-2 mt-2">

                            <!-- DETAIL -->
                            <a href="<?= base_url('buku/detail/' . $b['id_buku'] . '?from=peminjaman') ?>"
                                class="btn btn-sm btn-info">
                                Detail
                            </a>

                            <!-- PINJAM -->
                            <form method="post" action="<?= base_url('peminjaman/tambahDetail') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">

                                <button class="btn btn-sm btn-success"
                                    <?= ($b['tersedia'] <= 0) ? 'disabled' : '' ?>>
                                    + Pinjam
                                </button>
                            </form>

                        </div>

                        <?php if ($b['tersedia'] <= 0): ?>
                            <small class="text-danger d-block mt-2">
                                Stok habis
                            </small>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <hr>

    <!-- ================== KERANJANG ================== -->
    <h4>📦 Buku yang dipilih</h4>

    <div class="row">

        <?php if (!empty($keranjang)): ?>
            <?php foreach ($keranjang as $k): ?>
                <div class="col-md-4 mb-3">

                    <div class="card shadow-sm border-0">

                        <div class="row g-0">

                            <div class="col-4" style="background:#f8f9fa; display:flex; align-items:center;">
                                <img src="<?= base_url('uploads/buku/' . $k['cover']) ?>"
                                    style="width:100%; object-fit:contain;">
                            </div>

                            <div class="col-8">
                                <div class="card-body p-2">

                                    <h6><?= $k['judul'] ?></h6>

                                    <!-- UPDATE JUMLAH -->
                                    <form method="post" action="<?= base_url('peminjaman/updateJumlah') ?>"
                                        class="d-flex gap-1">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_buku" value="<?= $k['id_buku'] ?>">

                                        <input type="number"
                                            name="jumlah"
                                            value="<?= $k['jumlah'] ?>"
                                            class="form-control form-control-sm"
                                            style="width:70px;" min="1">

                                        <button class="btn btn-sm btn-warning">Update</button>
                                    </form>

                                    <!-- HAPUS -->
                                    <a href="<?= base_url('peminjaman/hapus/' . $k['id_buku']) ?>"
                                        class="btn btn-sm btn-danger mt-2">
                                        Hapus
                                    </a>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada buku dipilih</p>
        <?php endif; ?>

    </div>

    <hr>

    <!-- ================== FORM SIMPAN ================== -->
    <div class="card p-4 shadow-sm border-0">
        <h5>📝 Simpan Peminjaman</h5>

        <form method="post" action="<?= base_url('peminjaman/store') ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label>Anggota</label>
                <select name="id_anggota" class="form-control" required>
                    <option value="">-- Pilih Anggota --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>">
                            <?= $a['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Tanggal Pinjam</label>
                <input type="date"
                    name="tanggal_pinjam"
                    class="form-control"
                    value="<?= date('Y-m-d') ?>"
                    required>
            </div>

            <div class="mb-3">
                <label>Tanggal Kembali</label>
                <input type="date"
                    name="tanggal_kembali"
                    class="form-control"
                    required>
            </div>

            <button class="btn btn-primary">💾 Simpan</button>

        </form>
    </div>

</div>

<!-- ================== SCRIPT ================== -->
<script>
    const tglPinjam = document.querySelector('[name="tanggal_pinjam"]');
    const tglKembali = document.querySelector('[name="tanggal_kembali"]');

    function setTanggalKembali() {
        let tgl = new Date(tglPinjam.value);
        tgl.setDate(tgl.getDate() + 7);

        let hasil = tgl.toISOString().split('T')[0];
        tglKembali.value = hasil;
    }

    window.onload = function() {
        setTanggalKembali();
    }

    tglPinjam.addEventListener('change', function() {
        setTanggalKembali();
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        if (tglKembali.value < tglPinjam.value) {
            alert('Tanggal kembali tidak boleh sebelum tanggal pinjam!');
            e.preventDefault();
        }
    });
</script>

<?= $this->endSection() ?>