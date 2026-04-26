<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Print Data Users</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #000;
        }

        h2,
        h4 {
            margin: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        table td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 14px;
        }
    </style>
</head>

<body onload="window.print()">

    <!-- HEADER -->
    <div class="header">
        <h2>DATA USERS</h2>
        <h4>Sistem Perpustakaan</h4>
    </div>

    <!-- INFO -->
    <div class="info">
        <b>Tanggal Cetak:</b>
        <?= date('d-m-Y H:i') ?>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Username</th>
                <th width="100">Role</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($users)): ?>
                <?php $no = 1; ?>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= esc($u['nama']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td class="text-center"><?= ucfirst($u['role']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>
            Dicetak oleh sistem <br><br>
            ______________________
        </p>
    </div>

</body>

</html>