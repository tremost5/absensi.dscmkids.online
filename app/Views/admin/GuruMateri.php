<?php

namespace App\Controllers;

class GuruMateri extends BaseController
{
    public function index()
    {
        $kelasGuru = session()->get('kelas_id'); 
        // asumsi guru punya kelas_id

        $db = \Config\Database::connect();
        $materi = $db->table('materi_ajar')
            ->where('kelas_id', $kelasGuru)
            ->orderBy('created_at','DESC')
            ->get()
            ->getResultArray();

        return view('guru/materi', [
            'materi' => $materi,
            'kelas'  => $kelasGuru
        ]);
    }
}
