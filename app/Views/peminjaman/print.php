<!DOCTYPE html>
<html>

<head>
    <title>Print Data Peminjaman</title>
</head>

<body onload="window.print()">

    <h2 style="text-align:center;">Data Peminjaman Buku</h2>

    <table border="1" width="100%" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama Anggota</th>
            <th>Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
        </tr>

        <?php $no = 1; ?>
        <?php foreach ($peminjaman as $p): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['nama_anggota'] ?? '-' ?></td>
                <td>
                    <?php foreach ($p['buku'] as $b): ?>
                        <?= $b['judul'] ?><br>
                    <?php endforeach; ?>
                </td>
                <td><?= $p['tanggal_pinjam'] ?></td>
                <td><?= $p['tanggal_kembali'] ?></td>
                <td><?= $p['status'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>