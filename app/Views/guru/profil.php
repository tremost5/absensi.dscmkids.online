<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h1>Profil Saya</h1>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data"
      action="/guru/profil/update">

<div class="form-group text-center">
  <img src="/uploads/profile/<?= esc($user['foto']) ?>"
       class="img-circle mb-2"
       style="width:120px;height:120px;object-fit:cover">
</div>

<div class="form-group">
  <label>Ganti Foto</label>
  <input type="file" name="foto" class="form-control">
</div>

<div class="form-group">
  <label>Password Baru</label>
  <input type="password" name="password" class="form-control"
         placeholder="Kosongkan jika tidak ganti">
</div>

<button class="btn btn-success btn-block">
  💾 Simpan Perubahan
</button>

</form>

<?= $this->endSection() ?>
