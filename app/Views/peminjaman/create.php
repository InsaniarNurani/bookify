<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <!-- HEADER -->
    <div class="mb-3">
        <h3 class="fw-bold">
            <i class="bi bi-journal-plus me-2"></i>Tambah Peminjaman
        </h3>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form method="post" action="<?= base_url('peminjaman/store') ?>">

                <!-- 🔹 INFO ATAS -->
                <div class="row g-3">

                    <!-- KIRI -->
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded h-100">

                            <p class="mb-2">
                                Nama Anggota:<br>
                                <b><?= session()->get('nama') ?></b>
                            </p>

                            <p class="mb-2">
                                Tanggal Pinjam:<br>
                                <b><?= date('Y-m-d') ?></b>
                            </p>

                            <p class="mb-0">
                                Tanggal Kembali:<br>
                                <b><?= date('Y-m-d', strtotime('+7 days')) ?></b>
                            </p>

                        </div>
                    </div>

                    <!-- KANAN -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded h-100">

                            <label class="form-label fw-semibold">
                                Metode Pengantaran
                            </label>

                            <select name="metode_pengantaran" id="metode" class="form-select mb-2">
                                <option value="ambil">Ambil di Perpustakaan</option>
                                <option value="diantar">Diantar ke Rumah</option>
                            </select>

                            <!-- FIX: hanya 1 alamat (yang benar) -->
                            <div id="alamatBox">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" placeholder="Alamat lengkap"></textarea>
                            </div>

                        </div>
                    </div>

                </div>

                <hr>

                <!-- 🔻 BUKU -->
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-book me-1"></i>Pilih Buku (max 2)
                </h5>

                <div class="row g-2">

                    <?php foreach ($buku as $b): ?>
                        <div class="col-4 col-md-2">

                            <label class="card border-0 shadow-sm text-center p-1 buku-item">

                                <!-- checkbox -->
                                <input type="checkbox"
                                    name="id_buku[]"
                                    value="<?= $b['id_buku'] ?>"
                                    class="buku-check mb-1"
                                    <?= ($b['tersedia'] ?? 0) <= 0 ? 'disabled' : '' ?>>

                                <!-- cover -->
                                <img src="<?= base_url('uploads/buku/' . $b['cover']) ?>"
                                    class="img-fluid rounded mb-1"
                                    style="height:100px; object-fit:cover;"
                                    loading="lazy"
                                    onerror="this.src='<?= base_url('assets/no-image.png') ?>'">

                                <!-- judul -->
                                <small class="fw-semibold d-block text-truncate">
                                    <?= $b['judul'] ?>
                                </small>

                                <!-- stok -->
                                <?php if (($b['tersedia'] ?? 0) > 0): ?>
                                    <small class="text-success">
                                        <?= $b['tersedia'] ?>
                                    </small>
                                <?php else: ?>
                                    <small class="text-danger">
                                        Habis
                                    </small>
                                <?php endif; ?>

                            </label>

                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- BUTTON -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- STYLE -->
<style>
    .buku-item {
        cursor: pointer;
        transition: 0.2s;
    }

    .buku-item:hover {
        transform: scale(1.05);
    }

    .buku-item small {
        font-size: 11px;
    }

    .buku-check:checked+img {
        outline: 2px solid #0d6efd;
        border-radius: 6px;
    }
</style>

<!-- SCRIPT -->
<script>
    const metode = document.getElementById('metode');
    const alamatBox = document.getElementById('alamatBox');

    metode.addEventListener('change', function() {
        alamatBox.style.display = (this.value === 'diantar') ? 'block' : 'none';
    });

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