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
            $jumlahDipilih = $keranjang[$b['id_buku']]['jumlah'] ?? 0;
            $totalItem = count($keranjang);
            ?>

            <div class="col-md-3 mb-4">

                <div class="card shadow-sm h-100 border-0 position-relative">

                    <!-- COVER -->
                    <div style="height:200px; display:flex; align-items:center; justify-content:center; background:#f8f9fa;">
                        <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>"
                            style="max-height:100%; max-width:100%; object-fit:contain;">
                    </div>

                    <!-- BADGE -->
                    <?php if ($jumlahDipilih > 0): ?>
                        <span style="position:absolute;top:10px;right:10px;background:red;color:white;
                        padding:5px 10px;border-radius:50%;">
                            <?= $jumlahDipilih ?>
                        </span>
                    <?php endif; ?>

                    <div class="card-body text-center">

                        <h6><?= $b['judul'] ?></h6>
                        <small class="text-muted">Stok: <?= $b['tersedia'] ?></small>

                        <div class="mt-2 d-flex justify-content-center gap-2">

                            <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>"
                                class="btn btn-info btn-sm">
                                Detail
                            </a>

                            <!-- PINJAM -->
                            <form method="post" action="<?= base_url('peminjaman/tambahDetail') ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">

                                <button class="btn btn-success btn-sm"
                                    <?= ($b['tersedia'] <= 0 || ($jumlahDipilih == 0 && $totalItem >= 2)) ? 'disabled' : '' ?>>
                                    + Pinjam
                                </button>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <hr>

    <!-- ================== KERANJANG ================== -->
    <h4>📦 Buku Dipilih (Maksimal 2 Buku)</h4>

    <div class="row">

        <?php if (!empty($keranjang)): ?>

            <?php foreach ($keranjang as $k): ?>
                <div class="col-md-4 mb-3">

                    <div class="card shadow-sm">

                        <div class="row g-0">

                            <div class="col-4">
                                <img src="<?= base_url('uploads/buku/' . $k['cover']) ?>"
                                    style="width:100%; object-fit:contain;">
                            </div>

                            <div class="col-8 p-2">

                                <h6><?= $k['judul'] ?></h6>

                                <form method="post" action="<?= base_url('peminjaman/updateJumlah') ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_buku" value="<?= $k['id_buku'] ?>">

                                    <input type="number"
                                        name="jumlah"
                                        value="<?= $k['jumlah'] ?>"
                                        min="1"
                                        class="form-control form-control-sm">

                                    <button class="btn btn-warning btn-sm mt-1">Update</button>
                                </form>

                                <a href="<?= base_url('peminjaman/hapus/' . $k['id_buku']) ?>"
                                    class="btn btn-danger btn-sm mt-2">
                                    Hapus
                                </a>

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
    <div class="card p-4 shadow-sm">

        <h5>📝 Simpan Peminjaman</h5>

        <form id="formPeminjaman" method="post" action="<?= base_url('peminjaman/store') ?>">
            <?= csrf_field() ?>

            <!-- ANGGOTA -->
            <div class="mb-3">
                <label>Anggota</label>
                <select name="id_anggota" id="anggota" class="form-control" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($anggota as $a): ?>
                        <option value="<?= $a['id_anggota'] ?>"
                            data-alamat="<?= $a['alamat'] ?>">
                            <?= $a['nama'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- METODE -->
            <div class="mb-3">
                <label>Metode</label>
                <select name="metode" id="metode" class="form-control">
                    <option value="langsung">Pinjam Langsung</option>
                    <option value="dikirim">Dikirim</option>
                </select>
            </div>

            <!-- ALAMAT -->
            <div class="mb-3" id="boxAlamat" style="display:none;">
                <label>Alamat</label>
                <textarea id="alamat" class="form-control" readonly></textarea>
            </div>

            <!-- TANGGAL -->
            <div class="mb-3">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam"
                    value="<?= date('Y-m-d') ?>" class="form-control">
            </div>

            <div class="mb-3">
                <label>Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="form-control">
            </div>

            <button class="btn btn-primary">💾 Simpan</button>

        </form>

    </div>

</div>

<!-- ================== SCRIPT ================== -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const metode = document.getElementById('metode');
        const anggota = document.getElementById('anggota');
        const boxAlamat = document.getElementById('boxAlamat');
        const alamat = document.getElementById('alamat');
        const form = document.getElementById('formPeminjaman');

        function tampilAlamat() {
            let selected = anggota.options[anggota.selectedIndex];
            let alamatText = selected?.getAttribute('data-alamat') || '';

            if (metode.value === 'dikirim') {
                boxAlamat.style.display = 'block';
                alamat.value = alamatText || 'Alamat tidak tersedia';
            } else {
                boxAlamat.style.display = 'none';
                alamat.value = '';
            }
        }

        metode.addEventListener('change', tampilAlamat);
        anggota.addEventListener('change', tampilAlamat);

        form.addEventListener('submit', function(e) {
            let pinjam = document.querySelector('[name="tanggal_pinjam"]').value;
            let kembali = document.querySelector('[name="tanggal_kembali"]').value;

            if (kembali < pinjam) {
                alert("Tanggal tidak valid!");
                e.preventDefault();
            }
        });

    });
</script>

<?= $this->endSection() ?>