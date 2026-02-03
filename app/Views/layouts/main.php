<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/assets/adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="/assets/adminlte/plugins/fontawesome-free/css/all.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="/logout" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/dashboard" class="brand-link">
            <span class="brand-text font-weight-light">ABSENSI DSMC</span>
        </a>

        <div class="sidebar">
            <?= view('partials/sidebar') ?>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-3">
        <?= $this->renderSection('content') ?>
    </div>

</div>

<script src="/assets/adminlte/plugins/jquery/jquery.min.js"></script>
<script src="/assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/adminlte/js/adminlte.min.js"></script>
</body>
</html>
