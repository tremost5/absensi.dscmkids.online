<?php

namespace App\Controllers;

use App\Models\AuditLogModel;

class AdminMateri extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $materi = $this->db->table('materi_ajar')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();

        return view('admin/bahan_ajar', compact('materi'));
    }

    public function upload()
    {
        $judul    = trim($this->request->getPost('judul'));
        $catatan  = trim($this->request->getPost('catatan'));
        $kelas_id = $this->request->getPost('kelas_id');
        $kategori = $this->request->getPost('kategori');
        $link     = trim($this->request->getPost('link'));
        $file     = $this->request->getFile('file');

        if (!$judul || !$kelas_id) {
            return back()->with('error', 'Judul dan kelas wajib diisi');
        }

        $namaFile = null;

        if ($file && $file->isValid()) {
            $namaFile = time() . '_' . $file->getRandomName();
            $file->move(FCPATH . 'uploads/materi', $namaFile);
        }

        $this->db->table('materi_ajar')->insert([
            'judul'      => $judul,
            'catatan'    => $catatan,
            'kelas_id'   => $kelas_id,
            'kategori'   => $kategori ?: null,
            'file'       => $namaFile,
            'link'       => $link ?: null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Materi berhasil diupload');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $materi = $this->db->table('materi_ajar')->where('id', $id)->get()->getRowArray();

        if (!$materi) {
            return redirect()->to('/dashboard/admin/bahan-ajar')
                ->with('error', 'Materi tidak ditemukan');
        }

        return view('admin/bahan_ajar_edit', compact('materi'));
    }

    public function update($id)
    {
        $materi = $this->db->table('materi_ajar')->where('id', $id)->get()->getRowArray();
        if (!$materi) return back()->with('error', 'Data tidak ditemukan');

        $judul   = trim($this->request->getPost('judul'));
        $catatan = trim($this->request->getPost('catatan'));
        $file    = $this->request->getFile('file');

        if (!$judul) return back()->with('error', 'Judul wajib diisi');

        $update = [
            'judul'   => $judul,
            'catatan' => $catatan
        ];

        if ($file && $file->isValid()) {
            $namaFile = time() . '_' . $file->getRandomName();
            $file->move(FCPATH . 'uploads/materi', $namaFile);
            $update['file'] = $namaFile;
        }

        $this->db->table('materi_ajar')->where('id', $id)->update($update);

        return redirect()->to('/dashboard/admin/bahan-ajar')
            ->with('success', 'Materi berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->db->table('materi_ajar')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Materi dihapus');
    }
}
