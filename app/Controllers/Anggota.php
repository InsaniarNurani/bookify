<?php

namespace App\Controllers;

use App\Models\AnggotaModel;
use App\Models\UsersModel;

class Anggota extends BaseController
{
    protected $anggotaModel;
    protected $usersModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaModel();
        $this->usersModel = new UsersModel();
    }

    // 🔍 LIST + SEARCH
    public function index()
    {
        $keyword = $this->request->getGet('search');

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

    // 📥 FORM TAMBAH
    public function create()
    {
        $data['users'] = $this->usersModel->findAll();
        return view('anggota/create', $data);
    }

    // 💾 SIMPAN
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

    // ✏️ FORM EDIT
    public function edit($id)
    {
        $data['anggota'] = $this->anggotaModel->find($id);
        return view('anggota/edit', $data);
    }

    // 🔄 UPDATE
    public function update($id)
    {
        $this->anggotaModel->update($id, [
            'nis' => $this->request->getPost('nis'),
            'alamat' => $this->request->getPost('alamat'),
            'no_hp' => $this->request->getPost('no_hp'),
            'tanggal_daftar' => $this->request->getPost('tanggal_daftar'),
        ]);

        return redirect()->to('/anggota');
    }

    // ❌ DELETE
    public function delete($id)
    {
        $this->anggotaModel->delete($id);
        return redirect()->to('/anggota');
    }
}
