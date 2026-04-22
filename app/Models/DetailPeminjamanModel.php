<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_peminjaman',
        'id_anggota',
        'id_petugas',
        'id_buku',
        'jumlah'
    ];

    // ================= AMBIL DETAIL BUKU PER PEMINJAMAN =================
    public function getByPeminjaman($id_peminjaman)
    {
        return $this->db->table('detail_peminjaman')
            ->select('detail_peminjaman.*, buku.judul, buku.cover')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->where('detail_peminjaman.id_peminjaman', $id_peminjaman)
            ->get()
            ->getResultArray();
    }

    // ================= TAMBAH DETAIL =================
    public function tambah($data)
    {
        return $this->insert($data);
    }

    // ================= HAPUS DETAIL PER PEMINJAMAN =================
    public function hapusByPeminjaman($id_peminjaman)
    {
        return $this->where('id_peminjaman', $id_peminjaman)->delete();
    }
}
