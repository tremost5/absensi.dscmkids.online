<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h3>Edit Materi</h3>

<form method="post" enctype="multipart/form-data"
      action="<?= base_url('dashboard/admin/bahan-ajar/update/'.$materi['id']) ?>">

<div class="form-group">
    <label>Judul Materi</label>
    <input type="text" name="judul" class="form-control"
           value="<?= esc($materi['judul']) ?>" required>
</div>

<div class="form-group">
    <label>Catatan</label>
    <textarea name="catatan" class="form-control" rows="4"><?= esc($materi['catatan']) ?></textarea>
</div>

<?php if(!empty($materi['file'])): ?>
<div class="form-group">
    <label>File Saat Ini</label><br>
    <small class="text-muted"><?= esc($materi['file']) ?></small>
</div>
<?php endif; ?>

<div class="form-group">
    <label>Upload File Baru (opsional)</label>
    <input type="file" name="file" class="form-control">
</div>

<button class="btn btn-primary">
    💾 Simpan Perubahan
</button>

<a href="<?= base_url('dashboard/admin/bahan-ajar') ?>" class="btn btn-secondary">
    Kembali
</a>

</form>

<?= $this->endSection() ?>
