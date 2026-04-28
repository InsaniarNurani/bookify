<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new DashboardModel();

        $data = [
            'peminjaman' => $model->totalPeminjaman(),
            'pengembalian' => $model->totalPengembalian(),
            'notif' => $model->notifBelumKonfirmasi(),
            'buku' => $model->bukuTerbaru()
        ];

        return view('layouts/dashboard', $data);
    }
}
