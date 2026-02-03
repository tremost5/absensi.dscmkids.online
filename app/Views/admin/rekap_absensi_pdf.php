<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Rekap Absensi</title>

<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
}
.header {
    text-align: center;
    margin-bottom: 20px;
}
.header img {
    width: 80px;
    margin-bottom: 5px;
}
.header h2 {
    margin: 4px 0;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    border: 1px solid #333;
    padding: 6px;
}
th {
    background: #f0f0f0;
}
</style>
</head>
<body>

<?php
// ==================
// DEFAULT AMAN
// ==================
$tanggal = $tanggal ?? date('Y-m-d');

// MAP KELAS
$mapKelas = [
    1 => 'PG',
    2 => 'TKA',
    3 => 'TKB',
    4 => '1',
    5 => '2',
    6 => '3',
    7 => '4',
    8 => '5',
    9 => '6',
];

// MAP LOKASI
$mapLokasi = [
    1 => 'NICC',
    2 => 'GRASA',
    3 => 'CPM',
];
?>

<div class="header">
    <h2>REKAP ABSENSI SEKOLAH MINGGU</h2>
    <p>Tanggal: <?= esc($tanggal) ?></p>
</div>
<h3><?= esc($judul) ?></h3>
<table border="1" width="100%">
<table>
<thead>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Status</th>
    <th>Lokasi</th>
    <th>Jam</th>
    <th>Guru</th>
</tr>
</thead>
<tbody>

<?php if (empty($data)): ?>
<tr>
    <td colspan="7" style="text-align:center">
        Tidak ada data absensi
    </td>
</tr>
<?php endif; ?>

<?php $no=1; foreach ($data as $d): ?>
<tr>
    <td><?= $no++ ?></td>

    <!-- NAMA MURID -->
    <td><?= esc(trim(($d['nama_depan'] ?? '').' '.($d['nama_belakang'] ?? ''))) ?></td>

    <!-- KELAS -->
    <td><?= esc($mapKelas[$d['kelas_id']] ?? '-') ?></td>

    <!-- STATUS -->
    <td><?= esc($d['status']) ?></td>

    <!-- LOKASI -->
    <td><?= esc($mapLokasi[$d['lokasi_id']] ?? '-') ?></td>

    <!-- JAM -->
    <td><?= esc($d['jam']) ?></td>

    <!-- GURU -->
    <td><?= esc($d['guru_nama'] ?? '-') ?></td>

</tr>
<?php endforeach; ?>

</tbody>
</table>

</body>
</html>
