<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login Sistem Absensi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">

<style>
body {
    background: linear-gradient(135deg, #f857a6, #5b86e5);
}
.login-box {
    margin-top: 10vh;
}
.login-logo b {
    color: #fff;
}
.card {
    border-radius: 12px;
}
</style>
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <b>DSCM</b> Absensi
  </div>

  <div class="card">
    <div class="card-body login-card-body">

      <p class="login-box-msg">Silakan login</p>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>

      <form action="/login" method="post">
        <?= csrf_field() ?>

        <!-- USERNAME -->
        <div class="input-group mb-3">
          <input type="text"
                 name="username"
                 class="form-control"
                 placeholder="Username"
                 required
                 autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="input-group mb-3">
          <input type="password"
                 name="password"
                 class="form-control"
                 placeholder="Password"
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <!-- CAPTCHA -->
        <div class="input-group mb-3">
          <input type="number"
                 name="captcha"
                 class="form-control"
                 placeholder="<?= esc(session()->get('captcha_q')) ?>"
                 required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-shield-alt"></span>
            </div>
          </div>
        </div>

        <!-- SUBMIT -->
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">
              🔐 Login
            </button>
          </div>
        </div>
      </form>

      <hr>

      <p class="mb-1 text-center">
        <a href="/forgot">Lupa Password?</a>
      </p>

      <p class="mb-0 text-center">
        <a href="/register-guru" class="text-center">
          Daftar sebagai Guru
        </a>
      </p>

    </div>
  </div>
</div>

<script src="/assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/adminlte/js/adminlte.min.js"></script>

</body>
</html>
