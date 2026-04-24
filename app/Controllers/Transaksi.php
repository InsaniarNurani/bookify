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

        if ($keyword) {
            $data['transaksi'] = $this->transaksiModel
                ->like('jenis', $keyword)
                ->orLike('status', $keyword)
                ->orLike('id_peminjaman', $keyword)
                ->findAll();
        } else {
            $data['transaksi'] = $this->transaksiModel->findAll();
        }

        return view('transaksi/index', $data);
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
