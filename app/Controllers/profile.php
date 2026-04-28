<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Profile extends BaseController
{
    public function index()
    {
        $usersModel = new UsersModel();

        $id = session()->get('id'); // ambil user login

        $data['user'] = $usersModel->find($id);

        return view('profile/index', $data);
    }
}
