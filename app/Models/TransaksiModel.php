<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $allowedFields = [
        'id_peminjaman',
        'metode_pembayaran',
        'ongkir',
        'total_bayar',
        'bukti_pembayaran',
        'status',
        'jenis',
        'jumlah',
    ];
}
