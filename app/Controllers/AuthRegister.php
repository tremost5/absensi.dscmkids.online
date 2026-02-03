<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthRegister extends BaseController
{
    public function form()
    {
        return view('auth/register_guru');
    }

    public function store()
    {
        $model = new UserModel();

        $model->insert([
            'nama_depan'    => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'username'      => $this->request->getPost('username'),
            'password'      => password_hash(
                                $this->request->getPost('password'),
                                PASSWORD_DEFAULT
                              ),
            'email'         => $this->request->getPost('email'),
            'no_hp'         => $this->request->getPost('no_hp'),
            'alamat'        => $this->request->getPost('alamat'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'role_id'       => 3,
            'is_active'     => 0
        ]);

        return redirect()->to('/login')
            ->with('success', 'Pendaftaran berhasil, menunggu aktivasi admin');
    }
}
