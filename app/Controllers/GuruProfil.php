<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;

class GuruProfil extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $user  = $model->find(session()->get('user_id'));

        return view('guru/profil', ['user'=>$user]);
    }

    public function update()
    {
        $model = new UserModel();
        $audit = new AuditLogModel();
        $id    = session()->get('user_id');

        $data = [];

        // UPDATE PASSWORD
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }

        // UPDATE FOTO
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid()) {
            $namaFoto = time().'_'.$foto->getRandomName();
            $foto->move(FCPATH.'uploads/profile', $namaFoto);
            $data['foto'] = $namaFoto;
            session()->set('foto', $namaFoto);
        }

        if ($data) {
            $model->update($id, $data);

            $audit->insert([
                'user_id'    => $id,
                'aksi'       => 'UPDATE PROFIL',
                'keterangan' => 'Update foto/password',
                'ip_address' => $this->request->getIPAddress()
            ]);
        }

        return redirect()->back()
            ->with('success','Profil berhasil diperbarui');
    }
}
