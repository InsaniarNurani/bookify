<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    // =====================
    // READ + SEARCH
    // =====================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->transaksiModel->builder();

        $builder->select('
            transaksi.*,
            peminjaman.metode_pengantaran,
            peminjaman.ongkir,
            users.nama as nama_anggota
        ')
            ->join('peminjaman', 'peminjaman.id_peminjaman = transaksi.id_peminjaman')
            ->join('users', 'users.id = peminjaman.id_anggota');
        // kalau di peminjaman namanya user_id, ganti sesuai field kamu

        if ($keyword) {
            $builder->groupStart()
                ->like('transaksi.status', $keyword)
                ->orLike('users.nama', $keyword)
                ->groupEnd();
        }

        $data['transaksi'] = $builder->get()->getResultArray();

        return view('transaksi/index', $data);
    }
    public function detail($id)
    {
        $builder = $this->transaksiModel->builder();

        $builder->select('
        transaksi.*,
        peminjaman.metode_pengantaran,
        users.nama as nama_anggota
    ')
            ->join('peminjaman', 'peminjaman.id_peminjaman = transaksi.id_peminjaman')
            ->join('users', 'users.id = peminjaman.id_anggota') // sesuaikan field kamu
            ->where('transaksi.id_transaksi', $id);

        $data['transaksi'] = $builder->get()->getRowArray();

        return view('transaksi/detail', $data);
    }
    // =====================
    // CREATE FORM
    // =====================
    public function create()
    {
        return view('transaksi/create');
    }

    // =====================
    // STORE
    // =====================
    public function store()
    {
        $this->transaksiModel->save([
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'jenis' => $this->request->getPost('jenis'),
            'jumlah' => $this->request->getPost('jumlah'),
            'status' => 'belum_bayar'
        ]);

        return redirect()->to('/transaksi');
    }

    // =====================
    // EDIT FORM
    // =====================
    public function edit($id)
    {
        $data['transaksi'] = $this->transaksiModel->find($id);
        return view('transaksi/edit', $data);
    }

    // =====================
    // UPDATE
    // =====================
    public function update($id)
    {
        $this->transaksiModel->update($id, [
            'id_peminjaman' => $this->request->getPost('id_peminjaman'),
            'jenis' => $this->request->getPost('jenis'),
            'jumlah' => $this->request->getPost('jumlah'),
            'status' => $this->request->getPost('status')
        ]);

        return redirect()->to('/transaksi');
    }

    // =====================
    // DELETE
    // =====================
    public function delete($id)
    {
        $this->transaksiModel->delete($id);
        return redirect()->to('/transaksi');
    }

    // =====================
    // BAYAR / LUNAS
    // =====================
    public function bayar($id)
    {
        $this->transaksiModel->update($id, [
            'status' => 'lunas'
        ]);

        return redirect()->back();
    }
}
