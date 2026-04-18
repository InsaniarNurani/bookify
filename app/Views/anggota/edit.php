<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div>
    <div>
        <div>
            <h4>Edit Anggota</h4>
        </div>

        <div>

            <form action="<?= base_url('anggota/update/' . $anggota['id_anggota']) ?>" method="post">

                <!-- USER -->
                <div>
                    <label>User</label><br>
                    <select name="user_id" required>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id'] ?>"
                                <?= $u['id'] == $anggota['user_id'] ? 'selected' : '' ?>>
                                <?= $u['username'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <br>

                <!-- NIS -->
                <div>
                    <label>NIS</label><br>
                    <input type="text" name="nis" value="<?= $anggota['nis'] ?>" required>
                </div>

                <br>

                <!-- ALAMAT -->
                <div>
                    <label>Alamat</label><br>
                    <textarea name="alamat"><?= $anggota['alamat'] ?></textarea>
                </div>

                <br>

                <!-- NO HP -->
                <div>
                    <label>No HP</label><br>
                    <input type="text" name="no_hp" value="<?= $anggota['no_hp'] ?>">
                </div>

                <br>

                <!-- TANGGAL DAFTAR -->
                <div>
                    <label>Tanggal Daftar</label><br>
                    <input type="date" name="tanggal_daftar"
                        value="<?= $anggota['tanggal_daftar'] ?>">
                </div>

                <br>

                <button type="submit">Update</button>
                <a href="<?= base_url('anggota') ?>">Kembali</a>

            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>