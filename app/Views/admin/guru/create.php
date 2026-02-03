<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<section class="content-header">
  <h1>Tambah Guru</h1>
</section>

<section class="content">
<div class="card">
<div class="card-body">

<form method="post" action="/dashboard/admin/guru/store" enctype="multipart/form-data">

<div class="form-group">
  <label>Nama Depan</label>
  <input type="text" name="nama_depan" class="form-control" required>
</div>

<div class="form-group">
  <label>Nama Belakang</label>
  <input type="text" name="nama_belakang" class="form-control" required>
</div>

<div class="form-group">
  <label>Username</label>
  <input type="text" name="username" class="form-control" required>
</div>

<div class="form-group">
  <label>Password</label>
  <input type="password" name="password" class="form-control" required>
</div>

<div class="form-group">
  <label>Email</label>
  <input type="email" name="email" class="form-control" required>
</div>

<div class="form-group">
  <label>No. HP / WhatsApp</label>
  <input type="text" name="no_hp"
         class="form-control"
         pattern="[0-9]+"
         placeholder="08xxxxxxxx"
         required>
</div>

<div class="form-group">
  <label>Alamat</label>
  <textarea name="alamat" class="form-control" rows="3"></textarea>
</div>

<div class="form-group">
  <label>Tanggal Lahir</label>
  <input type="date" name="tanggal_lahir" class="form-control">
</div>

<div class="form-group">
  <label>Foto</label>
  <input type="file"
         name="foto"
         accept="image/*"
         capture="environment"
         class="form-control">
</div>

<hr>

<button class="btn btn-success btn-block btn-lg">
  💾 Simpan Guru
</button>

<a href="/dashboard/admin/guru"
   class="btn btn-secondary btn-block mt-2">
   ⬅️ Kembali
</a>

</form>

</div>
</div>
</section>

<?= $this->endSection() ?>
