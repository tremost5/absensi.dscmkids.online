<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MuridModel;

class GuruMurid extends BaseController
{
    protected $muridModel;

    public function __construct()
    {
        $this->muridModel = new MuridModel();
    }

    public function index()
{
    $murid = $this->muridModel
        ->select('id, nama_depan, nama_belakang, kelas_id')
        ->orderBy('kelas_id', 'ASC')
        ->findAll();

    return view('guru/murid_index', compact('murid'));
}


    public function create()
    {
        return view('guru/murid/create');
    }

    public function store()
    {
        $data = [
            'nama_depan'    => $this->request->getPost('nama_depan'),
            'nama_belakang' => $this->request->getPost('nama_belakang'),
            'kelas'         => $this->request->getPost('kelas'),
            'alamat'        => $this->request->getPost('alamat'),
            'no_hp'         => $this->request->getPost('no_hp'),
        ];

        // upload foto (optional)
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = 'murid_' . time() . '.' . $foto->getExtension();
            $foto->move(FCPATH . 'uploads/murid', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->muridModel->insert($data);

        return redirect()->to(base_url('guru/murid'))
            ->with('success', 'Murid berhasil ditambahkan');
    }
}
