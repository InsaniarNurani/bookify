<?php

namespace App\Controllers;

use App\Models\BukuModel;
use App\Models\PeminjamanModel;
use App\Models\PengembalianModel;
use App\Models\PenarikanModel;
use App\Models\TransaksiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();
        $pengembalianModel = new PengembalianModel();
        $penarikanModel = new PenarikanModel();

        $data = [
            'total_peminjaman' => $peminjamanModel->countAll(),

            'total_pengembalian' => $pengembalianModel
                ->where('status', 'dikembalikan')
                ->countAllResults(),

            'total_penarikan' => $penarikanModel->countAll(),

            // 🔥 TAMBAHAN BARU
            'menunggu_konfirmasi' => $peminjamanModel
                ->where('status', 'menunggu_konfirmasi')
                ->countAllResults(),
        ];

        return view('dashboard/index', $data);
    }
}
