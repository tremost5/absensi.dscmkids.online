<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= esc($title ?? 'Dashboard') ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- ADMINLTE CORE -->
<link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/adminlte/css/adminlte.min.css') ?>">

<!-- TOASTR -->
<link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.css') ?>">

<!-- CUSTOM CSS (WAJIB) -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<!-- ================= NAVBAR ================= -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img src="<?= base_url('uploads/profile/'.(session('foto') ?? 'default.png')) ?>"
             class="img-circle elevation-2"
             style="width:30px;height:30px;object-fit:cover">
        <?= esc(session('nama_depan')) ?>
      </a>

      <div class="dropdown-menu dropdown-menu-right">
        <a href="<?= base_url('guru/profil') ?>" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Profil
        </a>
        <div class="dropdown-divider"></div>
        <a href="<?= base_url('logout') ?>" class="dropdown-item text-danger">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
      </div>
    </li>
  </ul>

</nav>

<!-- ================= SIDEBAR ================= -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <a href="<?= base_url('dashboard/admin') ?>" class="brand-link text-center">
    <span class="brand-text font-weight-bold">ABSENSI DSMC</span>
  </a>

  <div class="sidebar">

    <?php if (session('role') == 2): ?>
      <?= view('partials/sidebar_admin') ?>
    <?php else: ?>
      <?= view('partials/sidebar') ?>
    <?php endif; ?>

  </div>
</aside>

<!-- ================= CONTENT ================= -->
<div class="content-wrapper">
  <section class="content pt-3">
    <?= $this->renderSection('content') ?>
  </section>
</div>

</div>

<!-- ================= SCRIPT ================= -->
<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/js/adminlte.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/toastr/toastr.min.js') ?>"></script>

<!-- CONFETTI -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
toastr.options = {
  closeButton: true,
  progressBar: true,
  positionClass: "toast-top-right",
  timeOut: "3000"
};

// CONFETTI AUTO UNTUK HBD TODAY
document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('.ultah-today')) {
    let end = Date.now() + 2500;
    (function frame() {
      confetti({ particleCount: 6, spread: 70, origin: { x: 0 }});
      confetti({ particleCount: 6, spread: 70, origin: { x: 1 }});
      if (Date.now() < end) requestAnimationFrame(frame);
    })();
  }
});
</script>

</body>
</html>
