<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return match (session()->get('role_id')) {
            1 => redirect()->to('/dashboard/superadmin'),
            2 => redirect()->to('/dashboard/admin'),
            3 => redirect()->to('/dashboard/guru'),
            default => redirect()->to('/logout'),
        };
    }

    // ==========================
    // DASHBOARD ADMIN
    // ==========================
    public function admin()
    {
        $userModel = new UserModel();
        $now = time();

        // ambil last_login saja (ringan)
        $guru = $userModel
            ->select('last_login')
            ->where('role_id', 3)
            ->findAll();

        $total   = count($guru);
        $online  = 0;
        $idle    = 0;
        $offline = 0;

        foreach ($guru as $g) {
            if (empty($g['last_login'])) {
                $offline++;
                continue;
            }

            $diff = $now - strtotime($g['last_login']);

            if ($diff <= 300) {
                $online++;
            } elseif ($diff <= 900) {
                $idle++;
            } else {
                $offline++;
            }
        }

        // 🎂 Ultah guru ±3 hari
        $ultahGuru = $userModel
            ->select('id, nama_depan, nama_belakang, tanggal_lahir, foto')
            ->where('role_id', 3)
            ->where('tanggal_lahir IS NOT NULL', null, false)
            ->where("
                DATE_FORMAT(tanggal_lahir,'%m-%d')
                BETWEEN
                DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 3 DAY),'%m-%d')
                AND
                DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 3 DAY),'%m-%d')
            ", null, false)
            ->findAll();

        return view('dashboard/admin', [
            'total_guru'   => $total,
            'guru_online'  => $online,
            'guru_idle'    => $idle,
            'guru_offline' => $offline,
            'ultahGuru'    => $ultahGuru
        ]);
    }

    // ==========================
    // JSON: GURU ONLINE REALTIME
    // ==========================
    public function guruOnlineJson()
{
    // pastikan JSON murni
    $this->response->setHeader('Content-Type', 'application/json');

    $userModel = new \App\Models\UserModel();
    $now = time();

    $guru = $userModel
        ->select('nama_depan, nama_belakang, last_login')
        ->where('role_id', 3)
        ->where('last_login IS NOT NULL', null, false)
        ->findAll();

    $online = [];

    foreach ($guru as $g) {
        $diff = $now - strtotime($g['last_login']);
        if ($diff <= 300) {
            $online[] = [
                'nama' => trim($g['nama_depan'] . ' ' . $g['nama_belakang']),
                'last_login' => date('H:i:s', strtotime($g['last_login']))
            ];
        }
    }

    return $this->response->setJSON($online);
}


    // ==========================
    // DASHBOARD GURU
    // ==========================
    public function guru()
    {
        return view('dashboard/guru');
    }

    // ==========================
    // DASHBOARD SUPERADMIN
    // ==========================
    public function superadmin()
    {
        return view('dashboard/superadmin');
    }
}
