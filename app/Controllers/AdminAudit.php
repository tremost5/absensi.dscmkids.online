<?php

namespace App\Controllers;

class AdminAudit extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $log = $db->table('audit_log al')
            ->select('al.*, u.nama_depan')
            ->join('users u','u.id=al.user_id')
            ->orderBy('al.created_at','DESC')
            ->get()
            ->getResultArray();

        return view('admin/audit_log', ['log'=>$log]);
    }
}
