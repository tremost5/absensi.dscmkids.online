<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<section class="content-header">
  <h1>Detail Absen Dobel</h1>
</section>

<section class="content">
<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>Nama Murid</th>
  <th>Kelas</th>
  <th>Lokasi</th>
  <th>Tanggal</th>
  <th>Jam</th>
  <th>Guru</th>
</tr>
</thead>
<tbody>

<?php foreach ($data as $d): ?>
<tr>
  <td><?= esc($d['nama_depan'].' '.$d['nama_belakang']) ?></td>
  <td><?= esc($d['kelas_id']) ?></td>
  <td><?= esc($d['lokasi_id']) ?></td>
  <td><?= esc($d['tanggal']) ?></td>
  <td><?= esc($d['jam']) ?></td>
  <td><?= esc($d['guru_nama']) ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

<a href="/guru/absensi" class="btn btn-secondary btn-block">
  ⬅️ Kembali ke Absensi
</a>

</div>
</div>
</section>

<?= $this->endSection() ?>
