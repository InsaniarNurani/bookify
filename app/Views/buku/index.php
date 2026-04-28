<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-book me-2"></i>Data Buku
        </h3>

        <div class="d-flex gap-2">
            <a href="<?= base_url('buku/create') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle me-1"></i>Tambah
            </a>
            <a href="<?= base_url('buku/print') ?>" target="_blank" class="btn btn-success btn-sm">
                <i class="bi bi-printer me-1"></i>Print
            </a>
        </div>
    </div>

    <!-- Search -->
    <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">
            <form method="get" class="row g-2 align-items-center">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="keyword" class="form-control"
                            placeholder="Cari judul buku...">
                    </div>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ISBN</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Rak</th>
                        <th>Tahun</th>
                        <th>Jumlah</th>
                        <th>Tersedia</th>
                        <th>Cover</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($buku as $b): ?>
                        <tr>
                            <td><?= $b['id_buku'] ?></td>
                            <td><?= $b['isbn'] ?></td>
                            <td class="fw-semibold"><?= $b['judul'] ?></td>
                            <td><span class="badge bg-secondary"><?= $b['nama_kategori'] ?></span></td>
                            <td><?= $b['nama_penulis'] ?></td>
                            <td><?= $b['nama_penerbit'] ?></td>
                            <td><?= $b['nama_rak'] ?></td>
                            <td><?= $b['tahun_terbit'] ?></td>
                            <td><?= $b['jumlah'] ?></td>
                            <td>
                                <span class="badge bg-success">
                                    <?= $b['tersedia'] ?>
                                </span>
                            </td>

                            <!-- Cover -->
                            <td>
                                <?php if (!empty($b['cover'])): ?>
                                    <img src="<?= base_url('uploads/buku/' . esc($b['cover'])) ?>"
                                        class="rounded shadow-sm"
                                        width="50" height="70"
                                        style="object-fit: cover;"
                                        onerror="this.src='<?= base_url('assets/no-image.png') ?>'">
                                <?php else: ?>
                                    <img src="<?= base_url('assets/no-image.png') ?>"
                                        class="rounded shadow-sm"
                                        width="50" height="70"
                                        style="object-fit: cover;">
                                <?php endif; ?>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">

                                    <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>"
                                        class="btn btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>"
                                        class="btn btn-warning text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <a href="<?= base_url('buku/delete/' . $b['id_buku']) ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('Yakin hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>


                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>