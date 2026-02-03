<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class AdminAbsensi extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // =========================
    // REKAP HARIAN + FILTER
    // =========================
    public function index()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
        $lokasi  = $this->request->getGet('lokasi') ?? '';
        $kelas   = $this->request->getGet('kelas') ?? '';
        $guru    = $this->request->getGet('guru') ?? '';

        // LIST GURU (UNTUK DROPDOWN)
        $guruList = $this->db->table('users')
            ->select('id,nama_depan,nama_belakang')
            ->where('role_id', 3)
            ->orderBy('nama_depan', 'ASC')
            ->get()
            ->getResultArray();

        $builder = $this->db->table('absensi_detail ad')
            ->select('
                m.nama_depan, m.nama_belakang,
                m.kelas_id,
                TRIM(UPPER(ad.status)) AS status,
                a.tanggal, a.jam, a.lokasi_id,
                u.nama_depan AS guru_depan,
                u.nama_belakang AS guru_belakang
            ')
            ->join('absensi a', 'a.id = ad.absensi_id')
            ->join('murid m', 'm.id = ad.murid_id')
            ->join('users u', 'u.id = a.guru_id', 'left')
            ->where('a.tanggal', $tanggal);

        if ($lokasi !== '') $builder->where('a.lokasi_id', $lokasi);
        if ($kelas  !== '') $builder->where('m.kelas_id', $kelas);
        if ($guru   !== '') $builder->where('a.guru_id', $guru);

        $data = $builder
            ->orderBy('m.kelas_id', 'ASC')
            ->orderBy('m.nama_depan', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/rekap_absensi', compact(
            'data','tanggal','lokasi','kelas','guru','guruList'
        ));
    }

    // =========================
    // EXPORT PDF (FILTER AKTIF)
    // =========================
    public function exportPdf()
    {
        $type  = $this->request->getGet('type') ?? 'harian';
        $guru  = $this->request->getGet('guru') ?? '';
        $judul = 'Rekap Absensi';
        $where = [];

        if ($type === 'mingguan') {
            $judul .= ' Mingguan';
            $where[] = "YEARWEEK(a.tanggal,1)=YEARWEEK(CURDATE(),1)";
        } elseif ($type === 'bulanan') {
            $judul .= ' Bulanan';
            $where[] = "MONTH(a.tanggal)=MONTH(CURDATE())";
            $where[] = "YEAR(a.tanggal)=YEAR(CURDATE())";
        } elseif ($type === 'tahunan') {
            $judul .= ' Tahunan';
            $where[] = "YEAR(a.tanggal)=YEAR(CURDATE())";
        } else {
            $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');
            $judul .= ' Harian';
            $where[] = "a.tanggal = '$tanggal'";
        }

        if ($guru !== '') {
            $where[] = "a.guru_id = $guru";
        }

        $sqlWhere = implode(' AND ', $where);

        $data = $this->db->query("
            SELECT
                m.nama_depan, m.nama_belakang,
                m.kelas_id,
                ad.status,
                a.tanggal, a.jam, a.lokasi_id,
                u.nama_depan AS guru_depan,
                u.nama_belakang AS guru_belakang
            FROM absensi_detail ad
            JOIN absensi a ON a.id = ad.absensi_id
            JOIN murid m ON m.id = ad.murid_id
            LEFT JOIN users u ON u.id = a.guru_id
            WHERE $sqlWhere
            ORDER BY a.tanggal ASC, m.kelas_id ASC, m.nama_depan ASC
        ")->getResultArray();

        $html = view('admin/rekap_absensi_pdf', [
            'data'  => $data,
            'judul' => $judul
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(
            'rekap_absensi_' . $type . '_' . date('Ymd_His') . '.pdf',
            ['Attachment' => true]
        );
        exit;
    }

    // =========================
    // EXPORT EXCEL (FILTER AKTIF)
    // =========================
    private function exportExcel($judul, $whereSql)
    {
        $data = $this->db->query("
            SELECT
                m.nama_depan, m.nama_belakang,
                m.kelas_id,
                ad.status,
                a.tanggal, a.jam, a.lokasi_id,
                u.nama_depan AS guru_depan,
                u.nama_belakang AS guru_belakang
            FROM absensi_detail ad
            JOIN absensi a ON a.id = ad.absensi_id
            JOIN murid m ON m.id = ad.murid_id
            LEFT JOIN users u ON u.id = a.guru_id
            WHERE $whereSql
            ORDER BY a.tanggal ASC, m.kelas_id ASC, m.nama_depan ASC
        ")->getResultArray();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename={$judul}.xls");

        echo "Nama\tKelas\tStatus\tLokasi\tTanggal\tJam\tGuru\n";
        foreach ($data as $d) {
            echo
                trim($d['nama_depan'].' '.$d['nama_belakang'])."\t".
                $d['kelas_id']."\t".
                $d['status']."\t".
                $d['lokasi_id']."\t".
                $d['tanggal']."\t".
                $d['jam']."\t".
                trim(($d['guru_depan'] ?? '').' '.($d['guru_belakang'] ?? '-'))."\n";
        }
        exit;
    }

    public function exportMingguan()
    {
        $this->exportExcel(
            'rekap_mingguan_' . date('o_W'),
            "YEARWEEK(a.tanggal,1)=YEARWEEK(CURDATE(),1)"
        );
    }

    public function exportBulanan()
    {
        $this->exportExcel(
            'rekap_bulanan_' . date('Y_m'),
            "MONTH(a.tanggal)=MONTH(CURDATE()) AND YEAR(a.tanggal)=YEAR(CURDATE())"
        );
    }

    public function exportTahunan()
    {
        $this->exportExcel(
            'rekap_tahunan_' . date('Y'),
            "YEAR(a.tanggal)=YEAR(CURDATE())"
        );
    }

    // =========================
    // STATISTIK PER KELAS
    // =========================
    public function statistik()
    {
        $rows = $this->db->table('absensi_detail ad')
            ->select('
                m.kelas_id,
                COUNT(ad.id) AS total,
                SUM(ad.status = "HADIR") AS hadir
            ')
            ->join('murid m', 'm.id = ad.murid_id')
            ->groupBy('m.kelas_id')
            ->orderBy('m.kelas_id', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/statistik_absensi', [
            'rows' => $rows
        ]);
    }
}
