<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h4>Edit Catatan Materi</h4>

<form action="<?= base_url('dashboard/admin/bahan-ajar/update-catatan/'.$materi['id']) ?>" method="post">

    <div class="form-group">
        <label>Judul Materi</label>
        <input type="text" class="form-control" value="<?= esc($materi['judul']) ?>" readonly>
    </div>

    <div class="form-group mt-3">
        <label>Catatan</label>
        <textarea name="catatan"
                  class="form-control"
                  rows="4"><?= esc($materi['catatan']) ?></textarea>
    </div>

    <button class="btn btn-primary btn-sm mt-3">
        <i class="fas fa-save"></i> Simpan
    </button>

    <a href="<?= base_url('dashboard/admin/bahan-ajar') ?>"
       class="btn btn-secondary btn-sm mt-3">
        Kembali
    </a>

</form>

<?= $this->endSection() ?>
