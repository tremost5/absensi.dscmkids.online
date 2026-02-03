<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MuridModel;

class Absensi extends BaseController
{
    protected $db;

    // Jadwal ibadah (RESMI)
    protected $jadwal = [
        'NICC'  => ['10:00', '12:30'],
        'GRASA' => ['17:00', '19:30'],
        'CPM'   => ['07:00', '09:30'],
    ];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function step1()
    {
        return view('guru/absensi_step1');
    }

    public function tampilkan()
    {
        $kelas  = (array)$this->request->getGet('kelas');
        $lokasi = $this->request->getGet('lokasi');

        if (!$kelas || !$lokasi) {
            return redirect()->to('guru/absensi');
        }

        $murid = (new MuridModel())
            ->whereIn('kelas_id', $kelas)
            ->orderBy('kelas_id', 'ASC')
            ->orderBy('nama_depan', 'ASC')
            ->findAll();

        return view('guru/absensi_step2', [
            'murid'  => $murid,
            'kelas'  => $kelas,
            'lokasi' => $lokasi
        ]);
    }

    // =================================================
    // SIMPAN ABSENSI (OVERLAP + LOG + EDIT RULE)
    // =================================================
    public function simpan()
    {
        // GET? DIAM.
        if ($this->request->getMethod() === 'get') {
            return $this->response->setStatusCode(204);
        }

        $guruId  = session()->get('user_id');
        $tanggal = date('Y-m-d');

        $kelas   = (array)$this->request->getPost('kelas');
        $hadir   = (array)$this->request->getPost('hadir');
        $lokasi  = $this->request->getPost('lokasi');

        $map = ['NICC'=>1,'GRASA'=>2,'CPM'=>3];
        $lokasiId = $map[$lokasi] ?? null;

        if (!$kelas || !$lokasiId) {
            return $this->response->setJSON([
                'status'=>'error','message'=>'Data tidak lengkap'
            ]);
        }

        $selfie = $this->request->getFile('selfie');
        if (!$selfie || !$selfie->isValid()) {
            return $this->response->setJSON([
                'status'=>'error','message'=>'Selfie wajib'
            ]);
        }

        // HEADER ABSENSI (1 guru / 1 lokasi / 1 hari)
        $absensi = $this->db->table('absensi')->where([
            'guru_id'   => $guruId,
            'tanggal'   => $tanggal,
            'lokasi_id' => $lokasiId
        ])->get()->getRow();

        if (!$absensi) {
            $namaSelfie = 'selfie_'.$guruId.'_'.time().'.jpg';
            $selfie->move(FCPATH.'uploads/selfie', $namaSelfie);

            $this->db->table('absensi')->insert([
                'guru_id'     => $guruId,
                'lokasi_id'   => $lokasiId,
                'tanggal'     => $tanggal,
                'jam'         => date('H:i:s'),
                'selfie_foto' => $namaSelfie
            ]);

            $absensiId = $this->db->insertID();
        } else {
            $absensiId = $absensi->id;
        }

        // JAM ABSENSI SEKARANG
        $now = date('H:i:s');

        // AMBIL SEMUA MURID TERKAIT
        $murid = $this->db->table('murid')
            ->whereIn('kelas_id', $kelas)
            ->get()->getResultArray();

        $konflik = [];

        foreach ($murid as $m) {

            $status = in_array($m['id'], $hadir) ? 'hadir' : 'tidak_hadir';
            $overlap = null;
            $overlapWith = null;

            // CEK APAKAH MURID SUDAH ADA ABSENSI DI LOKASI LAIN
            $existing = $this->db->table('absensi_detail ad')
                ->select('ad.*, a.lokasi_id, a.guru_id, a.jam')
                ->join('absensi a','a.id=ad.absensi_id')
                ->where('ad.murid_id', $m['id'])
                ->where('a.tanggal', $tanggal)
                ->where('a.lokasi_id !=', $lokasiId)
                ->get()->getRow();

            if ($existing) {
                // HITUNG SELISIH JAM
                $t1 = strtotime($existing->jam);
                $t2 = strtotime($now);
                $diffJam = abs($t2 - $t1) / 3600;

                if ($diffJam < 3) {
                    $status = 'overlap';
                    $overlap = date('Y-m-d H:i:s');
                    $overlapWith = $existing->guru_id;

                    // ambil nama guru pertama
$guru = $this->db->table('users')
    ->select('nama_depan')
    ->where('id', $existing->guru_id)
    ->get()->getRow();

$konflik[] = [
    'murid' => $m['nama_depan'].' '.$m['nama_belakang'],
    'guru'  => $guru ? $guru->nama_depan : 'Guru lain'
];

                }
            }

            // SIMPAN / UPDATE DETAIL
            $detail = $this->db->table('absensi_detail')->where([
                'absensi_id' => $absensiId,
                'murid_id'   => $m['id']
            ])->get()->getRow();

            if ($detail) {
                // UPDATE (EDIT ≤ 1 JAM)
                $created = strtotime($detail->created_at ?? date('Y-m-d H:i:s'));
                if (time() - $created > 3600) {
                    continue; // lewat 1 jam, skip
                }

                $this->db->table('absensi_detail')->where('id',$detail->id)->update([
                    'status'      => $status,
                    'overlap_at'  => $overlap,
                    'overlap_with_guru_id' => $overlapWith,
                    'updated_at'  => date('Y-m-d H:i:s')
                ]);

                $this->log($detail->id, $m['id'], 'update', $detail->status, $status, 'guru', $guruId);

            } else {
                // INSERT BARU
                $this->db->table('absensi_detail')->insert([
                    'absensi_id' => $absensiId,
                    'murid_id'   => $m['id'],
                    'status'     => $status,
                    'overlap_at' => $overlap,
                    'overlap_with_guru_id' => $overlapWith,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $detailId = $this->db->insertID();
                $this->log($detailId, $m['id'], 'create', null, $status, 'guru', $guruId);
            }
        }

        // SIMPAN KONFLIK KE SESSION (UNTUK GURU KE-2)
if (!empty($konflik)) {
    session()->setFlashdata('absensi_konflik', $konflik);
}

return $this->response->setJSON([
    'status'  => 'success',
    'message' => 'Absensi berhasil disimpan',
]);

    }

    // =====================
    // LOG ABSENSI
    // =====================
    protected function log($detailId, $muridId, $aksi, $lama, $baru, $oleh, $userId)
    {
        $this->db->table('absensi_log')->insert([
            'absensi_detail_id' => $detailId,
            'murid_id'          => $muridId,
            'aksi'              => $aksi,
            'status_lama'       => $lama,
            'status_baru'       => $baru,
            'oleh'              => $oleh,
            'user_id'           => $userId,
            'created_at'        => date('Y-m-d H:i:s')
        ]);
    }
    // =======================================
// ABSENSI HARI INI (VIEW)
// =======================================
public function hariIni()
{
    $guruId  = session()->get('user_id');
    $tanggal = date('Y-m-d');

    $absensi = $this->db->table('absensi')
        ->where('guru_id', $guruId)
        ->where('tanggal', $tanggal)
        ->orderBy('id','DESC')
        ->get()->getRow();

    if (!$absensi) {
        return view('guru/absensi_hari_ini', [
            'absensi' => null
        ]);
    }

    $detail = $this->db->table('absensi_detail ad')
        ->select('ad.*, m.nama_depan, m.nama_belakang, m.kelas_id')
        ->join('murid m','m.id=ad.murid_id')
        ->where('ad.absensi_id', $absensi->id)
        ->orderBy('m.kelas_id','ASC')
        ->orderBy('m.nama_depan','ASC')
        ->get()->getResultArray();

    return view('guru/absensi_hari_ini', [
        'absensi' => $absensi,
        'detail'  => $detail
    ]);
}

// =======================================
// SIMPAN EDIT (≤ 1 JAM)
// =======================================
public function simpanEditHariIni()
{
    if ($this->request->getMethod() !== 'post') {
        return redirect()->back();
    }

    $guruId = session()->get('user_id');
    $ids    = (array)$this->request->getPost('detail_id');
    $hadir  = (array)$this->request->getPost('hadir');

    foreach ($ids as $id) {
        $detail = $this->db->table('absensi_detail')
            ->where('id',$id)
            ->get()->getRow();

        if (!$detail) continue;

        // Cek kepemilikan & waktu edit
        $absen = $this->db->table('absensi')
            ->where('id',$detail->absensi_id)
            ->where('guru_id',$guruId)
            ->get()->getRow();

        if (!$absen) continue;

        $created = strtotime($detail->created_at);
        if (time() - $created > 3600) continue;

        $statusBaru = in_array($id, $hadir) ? 'hadir' : 'tidak_hadir';

        // Update detail (OVERLAP HILANG)
        $this->db->table('absensi_detail')->where('id',$id)->update([
            'status'      => $statusBaru,
            'overlap_at'  => null,
            'overlap_with_guru_id' => null,
            'updated_at'  => date('Y-m-d H:i:s'),
            'resolved_at' => date('Y-m-d H:i:s'),
            'resolved_by' => 'guru'
        ]);

        // LOG
        $this->log(
            $id,
            $detail->murid_id,
            'update',
            $detail->status,
            $statusBaru,
            'guru',
            $guruId
        );
    }

    return redirect()->to('guru/absensi-hari-ini')
        ->with('success','Perubahan absensi berhasil disimpan');
}

}
