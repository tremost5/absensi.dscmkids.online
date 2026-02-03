<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Guru</title>

<link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">
<style>
.login-box { max-width:420px; margin:auto }
</style>
</head>

<body class="login-page">

<div class="login-box">
<div class="card">
<div class="card-body">

<h4 class="text-center mb-3">Daftar Guru</h4>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<form method="post" action="/register-guru" enctype="multipart/form-data">

<input name="nama_depan" class="form-control mb-2" placeholder="Nama Depan *" required>
<input name="nama_belakang" class="form-control mb-2" placeholder="Nama Belakang">

<input name="username" class="form-control mb-2" placeholder="Username *" required>

<input type="password" name="password" class="form-control mb-2" placeholder="Password *" required>

<input type="email" name="email" class="form-control mb-2" placeholder="Email (reset password)" required>

<input name="no_hp" class="form-control mb-2" placeholder="No HP / WhatsApp *" pattern="[0-9]+" required>

<textarea name="alamat" class="form-control mb-2" placeholder="Alamat"></textarea>

<label class="mt-2">Tanggal Lahir</label>
<input type="date" name="tanggal_lahir" class="form-control mb-2">

<label class="mt-2">Foto Guru</label>
<input type="file"
       name="foto"
       class="form-control mb-3"
       accept="image/*"
       capture="environment">

<button class="btn btn-primary btn-block">
  Daftar Guru
</button>

</form>

<hr>
<a href="/login" class="btn btn-link btn-block">⬅ Kembali ke Login</a>

</div>
</div>
</div>

</body>
</html>
