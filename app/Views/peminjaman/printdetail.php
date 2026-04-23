<!DOCTYPE html>
<html>

<head>
    <title>Print Detail</title>
</head>

<body onload="window.print()">

    <h2>Detail Peminjaman</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <td><?= $peminjaman['id_peminjaman'] ?></td>
        </tr>
        <tr>
            <th>Nama Anggota</th>
            <td><?= $peminjaman['nama_anggota'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Petugas</th>
            <td><?= $peminjaman['nama_petugas'] ?? '-' ?></td>
        </tr>
        <tr>
            <th>Tanggal Pinjam</th>
            <td><?= $peminjaman['tanggal_pinjam'] ?></td>
        </tr>
        <tr>
            <th>Tanggal Kembali</th>
            <td><?= $peminjaman['tanggal_kembali'] ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= $peminjaman['status'] ?></td>
        </tr>
    </table>

</body>

</html>