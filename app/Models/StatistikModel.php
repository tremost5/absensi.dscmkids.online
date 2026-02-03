<?php

namespace App\Models;

use CodeIgniter\Model;

class StatistikModel extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function totalMurid()
    {
        return $this->db->table('murid')->countAllResults();
    }

    public function hadirHariIni()
    {
        return $this->db->table('absensi')
            ->where('tanggal', date('Y-m-d'))
            ->where('status', 'hadir')
            ->countAllResults();
    }

    public function absenPerBulan()
{
    $builder = $this->db->table('absensi');

    $builder->select('tanggal, status');
    $builder->where('status', 'hadir');

    $query = $builder->get();

    if ($query === false) {
        return [];
    }

    $data = [];

    foreach ($query->getResultArray() as $row) {
        $bulan = date('m', strtotime($row['tanggal']));
        $data[$bulan] = ($data[$bulan] ?? 0) + 1;
    }

    $result = [];
    foreach ($data as $bulan => $total) {
        $result[] = [
            'bulan' => (int)$bulan,
            'total' => $total
        ];
    }

    return $result;
}
}
