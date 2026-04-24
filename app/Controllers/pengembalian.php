<?php

namespace App\Controllers;

use App\Models\PengembalianModel;
use App\Models\PeminjamanModel;

class Pengembalian extends BaseController
{
    protected $pengembalianModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->pengembalianModel = new PengembalianModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    // ======================
    // LIST DATA
    // ======================
    public function index()
    {
        $model = new \App\Models\PengembalianModel();

        $data['pengembalian'] = $model
            ->select('pengembalian.*, peminjaman.tanggal_pinjam,
                      anggota.id_anggota, users.nama as nama_anggota')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->findAll();

        return view('pengembalian/index', $data);
    }

    // ======================
    // STORE (AUTO DENDA + STATUS)
    // ======================
    public function store()
    {
        $idPeminjaman = $this->request->getPost('id_peminjaman');

        $peminjaman = $this->peminjamanModel->find($idPeminjaman);

        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }

        // 🔥 AMANKAN FORMAT TANGGAL
        $tanggalDikembalikan = date('Y-m-d');
        $jatuhTempo = date('Y-m-d', strtotime($peminjaman['tanggal_kembali']));

        // 🔥 HITUNG SELISIH
        $selisihHari = (strtotime($tanggalDikembalikan) - strtotime($jatuhTempo)) / 86400;

        // 🔥 DEFAULT
        $denda = 0;
        $statusPengembalian = 'tepat_waktu';
        $statusBayar = null;

        // 🔥 JIKA TERLAMBAT
        if ($selisihHari > 0) {
            $denda = $selisihHari * 1000;
            $statusPengembalian = 'terlambat';
            $statusBayar = 'belum_bayar';
        }

        // 🔥 SIMPAN
        $this->pengembalianModel->save([
            'id_peminjaman' => $idPeminjaman,
            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'denda' => $denda,
            'status_pengembalian' => $statusPengembalian,
            'status_bayar' => $statusBayar
        ]);

        return redirect()->to('/pengembalian')->with('success', 'Berhasil dikembalikan');
    }

    // ======================
    // BAYAR DENDA
    // ======================
    public function bayar($id)
    {
        $this->pengembalianModel->update($id, [
            'status_bayar' => 'lunas'
        ]);

        return redirect()->back()->with('success', 'Denda dibayar');
    }

    // ======================
    // DETAIL
    // ======================
    public function detail($id)
    {
        $data['pengembalian'] = $this->pengembalianModel
            ->select('pengembalian.*, peminjaman.tanggal_pinjam')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->where('id_pengembalian', $id)
            ->first();

        return view('pengembalian/detail', $data);
    }

    // ======================
    // UPDATE (TANPA DENDA MANUAL)
    // ======================
    public function update($id)
    {
        $this->pengembalianModel->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'tanggal_dikembalikan' => $this->request->getPost('tanggal_dikembalikan')
        ]);

        return redirect()->to('/pengembalian');
    }

    // ======================
    // DELETE
    // ======================
    public function delete($id)
    {
        $this->pengembalianModel->delete($id);
        return redirect()->to('/pengembalian');
    }
}
