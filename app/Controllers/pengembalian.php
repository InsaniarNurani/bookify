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

    // READ (LIST)
    public function index()
    {
        $model = new \App\Models\PengembalianModel();

        $data['pengembalian'] = $model
            ->select('
            pengembalian.*,
            peminjaman.tanggal_pinjam,
            anggota.id_anggota,
            users.nama as nama_anggota,
            petugas.jabatan
        ')
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users', 'users.id = anggota.user_id', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->findAll();

        return view('pengembalian/index', $data);
    }

    // CREATE FORM
    public function create()
    {
        $data['peminjaman'] = $this->peminjamanModel->findAll();
        return view('pengembalian/create', $data);
    }

    // STORE DATA
    public function store()
    {
        $this->pengembalianModel->save([
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'tanggal_dikembalikan' => $this->request->getPost('tanggal_dikembalikan'),
            'denda' => $this->request->getPost('denda'),
        ]);

        return redirect()->to('/pengembalian');
    }

    // DETAIL
    public function detail($id)
    {
        $data['pengembalian'] = $this->pengembalianModel
            ->join('peminjaman', 'peminjaman.id_peminjaman = pengembalian.id_peminjaman', 'left')
            ->where('id_pengembalian', $id)
            ->first();

        return view('pengembalian/detail', $data);
    }

    // EDIT FORM
    public function edit($id)
    {
        $data['pengembalian'] = $this->pengembalianModel->find($id);
        $data['peminjaman'] = $this->peminjamanModel->findAll();

        return view('pengembalian/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $this->pengembalianModel->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'tanggal_dikembalikan' => $this->request->getPost('tanggal_dikembalikan'),
            'denda' => $this->request->getPost('denda'),
        ]);

        return redirect()->to('/pengembalian');
    }

    // DELETE
    public function delete($id)
    {
        $this->pengembalianModel->delete($id);
        return redirect()->to('/pengembalian');
    }
}
