<?php

namespace App\Controllers;

use App\Models\PenulisModel;

class Penulis extends BaseController
{
    protected $penulis;

    public function __construct()
    {
        $this->penulis = new PenulisModel();
    }

    public function index()
    {
        $data['penulis'] = $this->penulis->findAll();
        return view('penulis/index', $data);
    }

    public function create()
    {
        return view('penulis/create');
    }

    public function store()
    {
        $this->penulis->insert([
            'nama_penulis' => $this->request->getPost('nama_penulis')
        ]);

        return redirect()->to('/penulis');
    }

    public function edit($id)
    {
        $data['penulis'] = $this->penulis->find($id);
        return view('penulis/edit', $data);
    }

    public function update($id)
    {
        $this->penulis->update($id, [
            'nama_penulis' => $this->request->getPost('nama_penulis')
        ]);

        return redirect()->to('/penulis');
    }

    public function delete($id)
    {
        $this->penulis->delete($id);
        return redirect()->to('/penulis');
    }
}
