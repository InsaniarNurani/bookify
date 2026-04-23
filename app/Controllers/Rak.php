<?php

namespace App\Controllers;

use App\Models\RakModel;

class Rak extends BaseController
{
    protected $rak;

    public function __construct()
    {
        $this->rak = new RakModel();
    }

    // ================= INDEX =================
    public function index()
    {
        $session = session();

        // 🔒 hanya admin yang boleh akses
        if ($session->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak');
        }

        $model = new \App\Models\RakModel();

        $data['rak'] = $model->findAll();

        return view('rak/index', $data);
    }
    // ================= CREATE =================
    public function create()
    {
        return view('rak/create');
    }

    // ================= STORE =================
    public function store()
    {
        $this->rak->insert([
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi')
        ]);

        return redirect()->to('/rak');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $data['rak'] = $this->rak->find($id);
        return view('rak/edit', $data);
    }

    // ================= UPDATE =================
    public function update($id)
    {
        $this->rak->update($id, [
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi')
        ]);

        return redirect()->to('/rak');
    }

    // ================= DELETE =================
    public function delete($id)
    {
        $this->rak->delete($id);
        return redirect()->to('/rak');
    }
}
