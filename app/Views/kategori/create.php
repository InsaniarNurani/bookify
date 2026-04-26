<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-pencil-square me-2"></i>Edit Buku
        </h3>

        <a href="<?= base_url('buku') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Card Form -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form method="post"
                action="<?= base_url('buku/update/' . $buku['id_buku']) ?>"
                enctype="multipart/form-data">

                <div class="row g-3">

                    <!-- Judul -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Judul</label>
                        <input type="text" name="judul" class="form-control"
                            value="<?= $buku['judul'] ?>">
                    </div>

                    <!-- ISBN -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">ISBN</label>
                        <input type="text" name="isbn" class="form-control"
                            value="<?= $buku['isbn'] ?>">
                    </div>

                    <!-- Kategori -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kategori</label>
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
                        <label class="form-label fw-semibold">Penulis</label>
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
                        <label class="form-label fw-semibold">Penerbit</label>
                        <select name="id_penerbit" class="form-select">
                            <?php foreach ($penerbit as $p): ?>
                                <option value="<?= $p['id_penerbit'] ?>"
                                    <?= $buku['id_penerbit'] == $p['id_penerbit'] ? 'selected' : '' ?>>
                                    <?= $p['nama_penerbit'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Rak (AMAN, TIDAK UBAH LOGIC) -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Rak</label>
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
                        <label class="form-label fw-semibold">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control"
                            value="<?= $buku['tahun_terbit'] ?>">
                    </div>

                    <!-- Jumlah -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control"
                            value="<?= $buku['jumlah'] ?>">
                    </div>

                    <!-- Tersedia -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tersedia</label>
                        <input type="number" name="tersedia" class="form-control"
                            value="<?= $buku['tersedia'] ?>">
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= $buku['deskripsi'] ?></textarea>
                    </div>

                    <!-- Cover -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cover</label>
                        <input type="file" name="cover" class="form-control">

                        <div class="mt-2">
                            <?php if ($buku['cover']): ?>

                                <?php $ext = pathinfo($buku['cover'], PATHINFO_EXTENSION); ?>

                                <?php if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                    <img src="<?= base_url('uploads/buku/' . $buku['cover']) ?>"
                                        class="img-thumbnail shadow-sm mt-2"
                                        width="120">
                                <?php endif; ?>

                            <?php else: ?>
                                <small class="text-muted">Tidak ada cover</small>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!-- Button -->
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update
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