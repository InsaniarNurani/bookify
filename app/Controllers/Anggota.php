<?php

namespace App\Controllers;

use App\Models\AnggotaModel;

class Anggota extends BaseController
{
    protected $anggotaModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
    }

    // INDEX + SEARCH
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['anggota'] = $this->anggotaModel
                ->like('nis', $keyword)
                ->orLike('alamat', $keyword)
                ->orLike('no_hp', $keyword)
                ->findAll();
        } else {
            $data['anggota'] = $this->anggotaModel->findAll();
        }

        return view('anggota/index', $data);
    }

    // CREATE
    public function create()
    {
        return view('anggota/create');
    }

    public function store()
    {
        $this->anggotaModel->save([
            'user_id' => $this->request->getPost('user_id'),
            'nis' => $this->request->getPost('nis'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_daftar' => $this->request->getPost('tanggal_daftar'),
        ]);

        return redirect()->to('/anggota');
    }

    // EDIT
    public function edit($id)
    {
        $data['anggota'] = $this->anggotaModel->find($id);
        return view('anggota/edit', $data);
    }

    public function update($id)
    {
        $this->anggotaModel->update($id, [
            'user_id' => $this->request->getPost('user_id'),
            'nis' => $this->request->getPost('nis'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_daftar' => $this->request->getPost('tanggal_daftar'),
        ]);

        return redirect()->to('/anggota');
    }

    // DELETE
    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota');
    }
}
