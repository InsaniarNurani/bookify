<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    protected $allowedFields = [
        'user_id',
        'nis',
        'alamat',
        'no_hp',
        'tanggal_daftar'
    ];

    protected $useTimestamps = false;
}
