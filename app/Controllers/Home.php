<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\BukuModel;
use App\Models\PengembalianModel;

class Home extends BaseController
{
    public function index()
    {
        $peminjamanModel = new PeminjamanModel();
        $bukuModel = new BukuModel();
        $pengembalianModel = new PengembalianModel();

        $data = [
            'total_peminjaman' => $peminjamanModel->countAll(),
            'total_buku'       => $bukuModel->countAll(),
            'total_pengembalian' => $pengembalianModel->countAll(),

            // notifikasi belum dikonfirmasi
            'notif_belum_konfirmasi' => $peminjamanModel
                ->where('status', 'pending')
                ->countAllResults(),

            // buku terbaru (misal 5 data terakhir)
            'buku_baru' => $bukuModel
                ->orderBy('id_buku', 'DESC')
                ->findAll(5),
        ];

        return view('layouts/dashboard', $data);
    }
}
