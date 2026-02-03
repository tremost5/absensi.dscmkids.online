<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminGuru extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ===============================
    // LIST GURU
    // ===============================
    public function index()
    {
        $guru = $this->userModel
            ->where('role_id', 3)
            ->orderBy('nama_depan', 'ASC')
            ->findAll();

        return view('admin/guru/index', [
            'guru' => $guru
        ]);
    }

    // ===============================
    // FORM TAMBAH GURU
    // ===============================
    public function create()
    {
        return view('admin/guru/create');
    }

    // ===============================
    // SIMPAN GURU
    // ===============================
    public function store()
    {
        $this->userModel->insert([
            'nama_depan'  => $this->request->getPost('nama_depan'),
            'nama_belakang'=> $this->request->getPost('nama_belakang'),
            'username'    => $this->request->getPost('username'),
            'password'    => password_hash('123456', PASSWORD_DEFAULT),
            'role_id'     => 3,
            'status'      => 1
        ]);

        return redirect()->to('/dashboard/admin/guru')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    // ===============================
    // TOGGLE STATUS
    // ===============================
    public function toggle($id)
    {
        $guru = $this->userModel->find($id);

        if (!$guru) {
            return redirect()->back()
                ->with('error', 'Guru tidak ditemukan');
        }

        $this->userModel->update($id, [
            'status' => $guru['status'] ? 0 : 1
        ]);

        return redirect()->back()
            ->with('success', 'Status guru diubah');
    }
    // ================= REALTIME ONLINE JSON =================
    public function onlineJson()
{
    $model = new \App\Models\UserModel();

    $batas = date('Y-m-d H:i:s', strtotime('-5 minutes'));

    $guru = $model
        ->where('role_id', 3)
        ->where('status', 1)
        ->where('last_activity >=', $batas)
        ->findAll();

    return $this->response->setJSON($guru);
}


}
