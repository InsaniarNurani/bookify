<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    public function totalPeminjaman()
    {
        return $this->db->table('peminjaman')->countAllResults();
    }

    public function totalPengembalian()
    {
        return $this->db->table('pengembalian')->countAllResults();
    }

    public function bukuTerbaru()
    {
        return $this->db->table('buku')
            ->orderBy('id_buku', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }

    public function notifBelumKonfirmasi()
    {
        return $this->db->table('peminjaman')
            ->where('status', 'pending')
            ->countAllResults();
    }
}
