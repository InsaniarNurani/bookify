<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">

        <div class="card">
            <div class="card-header">
                <h4>Form Tambah Peminjaman</h4>
            </div>

            <div class="card-body">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('peminjaman/store') ?>" method="post">

                    <?= csrf_field() ?>

                    <!-- ANGGOTA -->
                    <div class="mb-3">
                        <label>Anggota</label>
                        <select name="id_anggota" class="form-control" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php foreach ($anggota as $a): ?>
                                <option value="<?= $a['id_anggota'] ?>">
                                    <?= $a['nis'] ?> - <?= $a['no_hp'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- PETUGAS -->
                    <div class="mb-3">
                        <label>Petugas</label>
                        <select name="id_petugas" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            <?php foreach ($petugas as $p): ?>
                                <option value="<?= $p['id_petugas'] ?>">
                                    <?= $p['jabatan'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- BUKU -->
                    <div class="mb-3">
                        <label>Buku</label>
                        <select name="id_buku" class="form-control" required>
                            <option value="">-- Pilih Buku --</option>
                            <?php foreach ($buku as $b): ?>
                                <option value="<?= $b['id_buku'] ?>">
                                    <?= $b['judul'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- TANGGAL PINJAM -->
                    <div class="mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control" required>
                    </div>

                    <!-- TANGGAL KEMBALI (AUTO) -->
                    <div class="mb-3">
                        <label>Tanggal Kembali (otomatis +7 hari)</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" readonly>
                    </div>

                    <!-- STATUS -->
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="dipinjam">Dipinjam</option>
                            <option value="dikembalikan">Dikembalikan</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= base_url('peminjaman') ?>" class="btn btn-secondary">Kembali</a>

                </form>

            </div>
        </div>

    </div>

    <script>
        document.getElementById("tanggal_pinjam").addEventListener("change", function() {
            let pinjam = new Date(this.value);

            if (!isNaN(pinjam)) {
                pinjam.setDate(pinjam.getDate() + 7);

                let kembali = pinjam.toISOString().split('T')[0];
                document.getElementById("tanggal_kembali").value = kembali;
            }
        });
    </script>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

</body>

</html>