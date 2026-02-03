<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<?php
$mapKelas = [1=>'PG',2=>'TKA',3=>'TKB',4=>'1',5=>'2',6=>'3',7=>'4',8=>'5',9=>'6'];
?>

<div class="card card-outline card-success mb-4">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-upload"></i> Upload Bahan Ajar</h3>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data"
          action="<?= base_url('dashboard/admin/bahan-ajar/upload') ?>">

      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Catatan</label>
        <textarea name="catatan" class="form-control" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label>Kelas</label>
        <select name="kelas_id" class="form-control" required>
          <option value="">-- Pilih --</option>
          <?php foreach($mapKelas as $id=>$nama): ?>
            <option value="<?= $id ?>"><?= $nama ?></option>
          <?php endforeach ?>
        </select>
      </div>

      <button class="btn btn-success btn-block">
        <i class="fas fa-cloud-upload-alt"></i> Upload
      </button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-book"></i> Daftar Materi</h3>
  </div>
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Kelas</th>
          <th>Kategori</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($materi as $m): ?>
        <tr>
          <td>
            <strong><?= esc($m['judul']) ?></strong>
            <?php if($m['catatan']): ?>
              <div class="text-muted small"><?= esc($m['catatan']) ?></div>
            <?php endif; ?>
          </td>
          <td><?= esc($mapKelas[$m['kelas_id']] ?? '-') ?></td>
          <td><?= $m['kategori'] ? strtoupper($m['kategori']) : '-' ?></td>
          <td>
            <a href="<?= base_url('dashboard/admin/bahan-ajar/edit/'.$m['id']) ?>"
               class="btn btn-sm btn-warning">
              <i class="fas fa-edit"></i>
            </a>

            <a href="<?= base_url('dashboard/admin/bahan-ajar/delete/'.$m['id']) ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Hapus materi ini?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
