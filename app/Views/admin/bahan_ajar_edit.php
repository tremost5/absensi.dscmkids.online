<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<div class="card card-warning">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-edit"></i> Edit Materi</h3>
  </div>

  <form method="post" enctype="multipart/form-data"
        action="<?= base_url('dashboard/admin/bahan-ajar/update/'.$materi['id']) ?>">

    <div class="card-body">

      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul"
               value="<?= esc($materi['judul']) ?>"
               class="form-control" required>
      </div>

      <div class="form-group">
        <label>Catatan</label>
        <textarea name="catatan"
                  class="form-control"
                  rows="3"><?= esc($materi['catatan']) ?></textarea>
      </div>

      <div class="form-group">
        <label>Upload File Baru (opsional)</label>
        <input type="file" name="file" class="form-control">
        <small class="text-muted">
          Kosongkan jika tidak ingin mengganti file
        </small>
      </div>

    </div>

    <div class="card-footer">
      <button class="btn btn-primary">
        <i class="fas fa-save"></i> Simpan
      </button>
      <a href="<?= base_url('dashboard/admin/bahan-ajar') ?>"
         class="btn btn-secondary">Batal</a>
    </div>

  </form>
</div>

<?= $this->endSection() ?>
