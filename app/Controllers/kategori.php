<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategori;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
    }

    // READ
    public function index()
    {
        $data['kategori'] = $this->kategori->findAll();
        return view('kategori/index', $data);
    }

    // CREATE FORM
    public function create()
    {
        return view('kategori/create');
    }

    // STORE
    public function store()
    {
        $this->kategori->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/kategori');
    }

    // EDIT FORM
    public function edit($id)
    {
        $data['kategori'] = $this->kategori->find($id);
        return view('kategori/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $this->kategori->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ]);

        return redirect()->to('/kategori');
    }

    // DELETE
    public function delete($id)
    {
        $this->kategori->delete($id);
        return redirect()->to('/kategori');
    }
}
