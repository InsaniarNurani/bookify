<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_peminjaman',
        'id_buku',
        'jumlah'
    ];

    public function getByPeminjaman($id_peminjaman)
    {
        return $this->db->table('detail_peminjaman')
            ->select('buku.judul, buku.cover')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->where('id_peminjaman', $id_peminjaman)
            ->get()->getResultArray();
    }
}
