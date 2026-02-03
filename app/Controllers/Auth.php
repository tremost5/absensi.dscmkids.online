<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AuditLogModel;

class Auth extends BaseController
{
    public function login()
    {
        $a = rand(1, 9);
        $b = rand(1, 9);

        session()->set([
            'captcha_ans' => $a + $b,
            'captcha_q'   => "$a + $b = ?"
        ]);

        return view('auth/login');
    }

    public function attemptLogin()
    {
        // ==========================
        // CAPTCHA CHECK
        // ==========================
        if ((int)$this->request->getPost('captcha') !== session()->get('captcha_ans')) {
            return redirect()->back()->with('error', 'Captcha salah');
        }

        $model = new UserModel();

        // ==========================
        // AMBIL USER
        // ==========================
        $user = $model
            ->where('username', $this->request->getPost('username'))
            ->where('status', 'aktif')
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan atau belum aktif');
        }

        // ==========================
        // CEK PASSWORD
        // ==========================
        if (!password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // ==========================
        // REGENERATE SESSION
        // ==========================
        session()->regenerate(true);

        // ==========================
        // UPDATE LOGIN INFO
        // ==========================
        $model->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s'),
            'last_seen'  => date('Y-m-d H:i:s')
        ]);

        // ==========================
        // SET SESSION
        // ==========================
        session()->set([
            'user_id'    => $user['id'],
            'nama_depan' => $user['nama_depan'],
            'role_id'    => $user['role_id'],
            'foto'       => $user['foto'],
            'isLoggedIn' => true
        ]);

        // ==========================
        // AUDIT LOG
        // ==========================
        $audit = new AuditLogModel();
        $audit->insert([
            'user_id'    => $user['id'],
            'aksi'       => 'LOGIN',
            'keterangan' => 'User login ke sistem',
            'ip_address' => $this->request->getIPAddress()
        ]);

        // ==========================
        // REDIRECT SESUAI ROLE
        // ==========================
        if ($user['role_id'] == 1) {
            return redirect()->to('/dashboard/superadmin');
        }

        if ($user['role_id'] == 2) {
            return redirect()->to('/dashboard/admin');
        }

        if ($user['role_id'] == 3) {
            return redirect()->to('/dashboard/guru');
        }

        // fallback (harusnya ga kepakai)
        return redirect()->to('/logout');
    }

    public function logout()
    {
        if (session()->get('user_id')) {
            $audit = new AuditLogModel();
            $audit->insert([
                'user_id'    => session()->get('user_id'),
                'aksi'       => 'LOGOUT',
                'keterangan' => 'User logout',
                'ip_address' => $this->request->getIPAddress()
            ]);
        }

        session()->destroy();
        return redirect()->to('/login');
    }
}
