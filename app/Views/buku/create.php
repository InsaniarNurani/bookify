<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<style>
    .form-card {
        border-radius: 16px;
        border: none;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control,
    textarea,
    select {
        border-radius: 10px !important;
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 20px;
    }

    .btn {
        border-radius: 10px;
    }

    .form-section {
        background: #fff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="container py-4">

    <div class="form-section">

        <h4 class="section-title">
            <i class="bi bi-book"></i> Tambah Buku
        </h4>

        <form method="post" action="<?= base_url('buku/store') ?>" enctype="multipart/form-data">

            <div class="row">

                <!-- KIRI -->
                <div class="col-md-6">

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control" placeholder="Judul buku">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="ISBN">
                    </div>

                    <!-- Kategori -->
                    <div class="mb-2">
                        <label class="form-label">Kategori</label>
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
                            class="form-control mt-2"
                            placeholder="Tulis kategori baru"
                            style="display:none;">
                    </div>

                    <!-- Penulis -->
                    <div class="mb-2">
                        <label class="form-label">Penulis</label>
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
                            class="form-control mt-2"
                            placeholder="Tulis penulis baru"
                            style="display:none;">
                    </div>

                </div>

                <!-- KANAN -->
                <div class="col-md-6">

                    <!-- Penerbit -->
                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
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
                            class="form-control mt-2"
                            placeholder="Tulis penerbit baru"
                            style="display:none;">
                    </div>

                    <!-- Rak -->
                    <div class="mb-3">
                        <label class="form-label">Rak</label>
                        <select name="id_rak" class="form-control">
                            <option value="">Pilih Rak</option>
                            <?php foreach ($rak as $r): ?>
                                <option value="<?= $r['id_rak'] ?>">
                                    <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tersedia</label>
                            <input type="number" name="tersedia" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <!-- FULL WIDTH -->
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Cover</label>
                <input type="file" name="cover" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan
                </button>

                <a href="<?= base_url('buku') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<script>
    document.getElementById('kategori').addEventListener('change', function() {
        document.getElementById('kategori_baru').style.display =
            (this.value === 'new') ? 'block' : 'none';
    });

    document.getElementById('penulis').addEventListener('change', function() {
        document.getElementById('penulis_baru').style.display =
            (this.value === 'new') ? 'block' : 'none';
    });

    document.getElementById('penerbit').addEventListener('change', function() {
        document.getElementById('penerbit_baru').style.display =
            (this.value === 'new') ? 'block' : 'none';
    });
</script>

<?= $this->endSection() ?> saya mau berikan tanda untuk setiap baris kolomnya