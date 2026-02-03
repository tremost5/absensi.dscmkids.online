<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h1>Audit Log</h1>

<div class="table-responsive">
<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>User</th>
  <th>Aksi</th>
  <th>Keterangan</th>
  <th>IP</th>
  <th>Waktu</th>
</tr>
</thead>
<tbody>

<?php foreach($log as $l): ?>
<tr>
  <td><?= esc($l['nama_depan']) ?></td>
  <td><?= esc($l['aksi']) ?></td>
  <td><?= esc($l['keterangan']) ?></td>
  <td><?= esc($l['ip_address']) ?></td>
  <td><?= esc($l['created_at']) ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>

<?= $this->endSection() ?>
