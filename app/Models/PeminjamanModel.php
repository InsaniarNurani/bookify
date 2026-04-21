<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $allowedFields = [
        'nama peminjam',

        'tanggal_pinjam',
        'tanggal_kembali',
        'metode',

        'status',
        'perpanjang',
        'ongkir'
    ];
}
