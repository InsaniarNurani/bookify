<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-pencil-square me-2"></i>Edit Buku
        </h3>

        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="post"
                action="<?= base_url('buku/update/' . $buku['id_buku']) ?>"
                enctype="multipart/form-data">

                <div class="row g-3">

                    <!-- Judul -->
                    <div class="col-md-6">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-control"
                            value="<?= $buku['judul'] ?>">
                    </div>

                    <!-- ISBN -->
                    <div class="col-md-6">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control"
                            value="<?= $buku['isbn'] ?>">
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select">
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori'] ?>"
                                    <?= $buku['id_kategori'] == $k['id_kategori'] ? 'selected' : '' ?>>
                                    <?= $k['nama_kategori'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Penulis -->
                    <div class="col-md-6">
                        <label class="form-label">Penulis</label>
                        <select name="id_penulis" class="form-select">
                            <?php foreach ($penulis as $p): ?>
                                <option value="<?= $p['id_penulis'] ?>"
                                    <?= $buku['id_penulis'] == $p['id_penulis'] ? 'selected' : '' ?>>
                                    <?= $p['nama_penulis'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Penerbit -->
                    <div class="col-md-6">
                        <label class="form-label">Penerbit</label>
                        <select name="id_penerbit" class="form-select">
                            <?php foreach ($penerbit as $p): ?>
                                <option value="<?= $p['id_penerbit'] ?>"
                                    <?= $buku['id_penerbit'] == $p['id_penerbit'] ? 'selected' : '' ?>>
                                    <?= $p['nama_penerbit'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Rak (INI AMAN, TIDAK DIUBAH LOGIC) -->
                    <div class="col-md-6">
                        <label class="form-label">Rak</label>
                        <select name="id_rak" class="form-select">
                            <?php foreach ($rak as $r): ?>
                                <option value="<?= $r['id_rak'] ?>"
                                    <?= isset($buku['id_rak']) && $buku['id_rak'] == $r['id_rak'] ? 'selected' : '' ?>>
                                    <?= $r['nama_rak'] ?> - <?= $r['lokasi'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tahun -->
                    <div class="col-md-4">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control"
                            value="<?= $buku['tahun_terbit'] ?>">
                    </div>

                    <!-- Jumlah -->
                    <div class="col-md-4">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control"
                            value="<?= $buku['jumlah'] ?>">
                    </div>

                    <!-- Tersedia -->
                    <div class="col-md-4">
                        <label class="form-label">Tersedia</label>
                        <input type="number" name="tersedia" class="form-control"
                            value="<?= $buku['tersedia'] ?>">
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= $buku['deskripsi'] ?></textarea>
                    </div>

                    <!-- Cover -->
                    <div class="col-md-6">
                        <label class="form-label">Cover</label>
                        <input type="file" name="cover" class="form-control mt-1">

                        <div class="mt-2">
                            <?php if ($buku['cover']): ?>

                                <?php $ext = pathinfo($buku['cover'], PATHINFO_EXTENSION); ?>

                                <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>"
                                        class="img-thumbnail mt-2"
                                        width="120">
                                <?php endif; ?>

                            <?php else: ?>
                                <small class="text-muted">Tidak ada cover</small>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!-- tombol -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update
                    </button>

                    <a href="<?= base_url('buku') ?>" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>