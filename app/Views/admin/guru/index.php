<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<section class="content-header">
  <h1>Manajemen Guru</h1>
</section>

<section class="content">
<div class="card">
<div class="card-body table-responsive">

<a href="<?= base_url('dashboard/admin/guru/create') ?>"
   class="btn btn-primary mb-3">
  ➕ Tambah Guru
</a>

<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>Nama</th>
  <th>Username</th>
  <th>Status</th>
  <th width="180">Aksi</th>
</tr>
</thead>
<tbody>

<?php if (empty($guru)): ?>
<tr>
  <td colspan="4" class="text-center text-muted">
    Belum ada data guru
  </td>
</tr>
<?php endif; ?>

<?php foreach ($guru as $g): ?>
<?php
  // nama belakang optional
  $nama = trim($g['nama_depan'].' '.($g['nama_belakang'] ?? ''));
?>
<tr>
  <td><?= esc($nama) ?></td>
  <td><?= esc($g['username']) ?></td>
  <td>
    <?= $g['status']
        ? '<span class="badge badge-success">Aktif</span>'
        : '<span class="badge badge-danger">Nonaktif</span>' ?>
  </td>
  <td>

    <!-- TOGGLE (GET, BUKAN POST) -->
    <a href="<?= base_url('dashboard/admin/guru/toggle/'.$g['id']) ?>"
       class="btn btn-sm btn-warning"
       onclick="return confirm('Ubah status guru ini?')">
       <?= $g['status'] ? 'Nonaktifkan' : 'Aktifkan' ?>
    </a>

  </td>
</tr>
<?php endforeach; ?>

</tbody>
</table>

</div>
</div>
</section>

<?= $this->endSection() ?>
