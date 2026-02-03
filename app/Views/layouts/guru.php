<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>

    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?= view('partials/navbar_guru') ?>
    <?= view('partials/sidebar_guru') ?>

    <div class="content-wrapper p-3">
        <?= $this->renderSection('content') ?>
    </div>

</div>

<script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
