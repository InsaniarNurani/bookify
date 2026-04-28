<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">

    <h3 class="fw-bold mb-3">Detail Profil</h3>

    <div class="card p-4 shadow-sm">

        <div class="text-center mb-3">

            <img src="<?= base_url('uploads/users/' . ($user['foto'] ?? 'default.png')) ?>"
                class="rounded-circle"
                width="120"
                height="120"
                style="object-fit: cover;">

        </div>

        <table class="table table-borderless">

            <tr>
                <th>Nama</th>
                <td><?= $user['nama'] ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= $user['email'] ?></td>
            </tr>

            <tr>
                <th>Username</th>
                <td><?= $user['username'] ?></td>
            </tr>

            <tr>
                <th>Role</th>
                <td><?= $user['role'] ?></td>
            </tr>

        </table>

    </div>

</div>

<?= $this->endSection() ?>