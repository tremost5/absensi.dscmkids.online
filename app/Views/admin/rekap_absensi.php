<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<?php
// ===============================
// DEFAULT AMAN (ANTI ERROR)
// ===============================
$tanggal = $tanggal ?? date('Y-m-d');
$lokasi  = $lokasi  ?? '';
$kelas   = $kelas   ?? '';
$guru    = $guru    ?? '';

$mapKelas = [
    1=>'PG',2=>'TKA',3=>'TKB',
    4=>'1',5=>'2',6=>'3',
    7=>'4',8=>'5',9=>'6'
];

$mapLokasi = [
    1=>'NICC',2=>'GRASA',3=>'CPM'
];
?>

<section class="content-header">
  <div class="container-fluid">
    <h1>Rekap Absensi</h1>
    <p class="text-muted">Data kehadiran siswa</p>
  </div>
</section>

<section class="content">
<div class="container-fluid">

<!-- FILTER -->
<form method="get" class="row mb-3">

  <div class="col-md-3 col-12 mb-2">
    <label>Tanggal</label>
    <input type="date" name="tanggal" value="<?= esc($tanggal) ?>" class="form-control">
  </div>

  <div class="col-md-3 col-12 mb-2">
    <label>Lokasi</label>
    <select name="lokasi" class="form-control">
      <option value="">Semua Lokasi</option>
      <?php foreach ($mapLokasi as $id=>$nama): ?>
        <option value="<?= $id ?>" <?= ($lokasi==$id)?'selected':'' ?>>
          <?= $nama ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-2 col-12 mb-2">
    <label>Kelas</label>
    <select name="kelas" class="form-control">
      <option value="">Semua</option>
      <?php foreach ($mapKelas as $id=>$nama): ?>
        <option value="<?= $id ?>" <?= ($kelas==$id)?'selected':'' ?>>
          <?= $nama ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3 col-12 mb-2">
    <label>Guru</label>
    <select name="guru" class="form-control">
      <option value="">Semua Guru</option>
      <?php foreach ($guruList ?? [] as $g): ?>
        <option value="<?= $g['id'] ?>" <?= ($guru==$g['id'])?'selected':'' ?>>
          <?= esc($g['nama_depan'].' '.$g['nama_belakang']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-1 col-12 mb-2 d-flex align-items-end">
    <button class="btn btn-primary btn-block">
      🔍
    </button>
  </div>

</form>

<!-- EXPORT -->
<a href="/dashboard/admin/rekap-absensi/export-pdf?
tanggal=<?= esc($tanggal) ?>&lokasi=<?= esc($lokasi) ?>&kelas=<?= esc($kelas) ?>&guru=<?= esc($guru) ?>"
class="btn btn-danger mb-3">
📄 Export PDF
</a>

<!-- TABEL -->
<div class="table-responsive">
<table class="table table-bordered table-striped table-sm">
<thead class="thead-light">
<tr>
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
  <td colspan="6" class="text-center text-muted">
    Tidak ada data absensi
  </td>
</tr>
<?php endif; ?>

<?php foreach ($data as $d): ?>
<tr>
  <td><?= esc($d['nama_depan'].' '.$d['nama_belakang']) ?></td>

  <td><?= kelasBadge($d['kelas_id']) ?></td>

  <td>
    <?php if ($d['status'] === 'HADIR'): ?>
      <span class="badge badge-success">HADIR</span>
    <?php else: ?>
      <span class="badge badge-secondary">TIDAK HADIR</span>
    <?php endif; ?>
  </td>

  <td><?= esc($mapLokasi[$d['lokasi_id']] ?? '-') ?></td>
  <td><?= esc($d['jam']) ?></td>

  <td>
    <?= esc(trim(($d['guru_depan'] ?? '').' '.($d['guru_belakang'] ?? ''))) ?: '-' ?>
  </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

</div>
</section>

<?= $this->endSection() ?>
