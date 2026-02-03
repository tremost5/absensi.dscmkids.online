<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h1>Bahan Ajar Kelas Anda</h1>

<?php if(empty($materi)): ?>
<div class="alert alert-info">
  Belum ada materi untuk kelas ini
</div>
<?php endif; ?>

<div class="list-group">
<?php foreach($materi as $m): ?>
  <a href="/uploads/materi/<?= esc($m['file']) ?>"
     target="_blank"
     class="list-group-item list-group-item-action">
     📘 <?= esc($m['judul']) ?>
  </a>
<?php endforeach; ?>
</div>

<?= $this->endSection() ?>
