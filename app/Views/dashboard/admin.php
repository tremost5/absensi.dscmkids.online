<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<section class="content-header">
  <div class="container-fluid">
    <h1>Dashboard Admin</h1>
    <p class="text-muted">Ringkasan aktivitas guru</p>
  </div>
</section>

<section class="content">
<div class="container-fluid">

<!-- INFO BOX -->
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= esc($total_guru ?? 0) ?></h3>
        <p>Total Guru</p>
      </div>
      <div class="icon"><i class="fas fa-users"></i></div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= esc($guru_online ?? 0) ?></h3>
        <p>Guru Online</p>
      </div>
      <div class="icon"><i class="fas fa-signal"></i></div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?= esc($guru_idle ?? 0) ?></h3>
        <p>Guru Idle</p>
      </div>
      <div class="icon"><i class="fas fa-pause-circle"></i></div>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?= esc($guru_offline ?? 0) ?></h3>
        <p>Guru Offline</p>
      </div>
      <div class="icon"><i class="fas fa-times-circle"></i></div>
    </div>
  </div>
</div>

<!-- ULTAH GURU -->
<div class="card card-outline card-warning">
  <div class="card-header">
    <h3 class="card-title mb-0">
      🎂 Ulang Tahun Guru <small>(± 3 Hari)</small>
    </h3>
  </div>

  <div class="card-body">
    <?php if (empty($ultahGuru)): ?>
      <div class="text-center text-muted">
        Tidak ada guru yang ulang tahun
      </div>
    <?php else: ?>
    <div class="row">
      <?php foreach ($ultahGuru as $g): 
        $isToday = date('md') === date('md', strtotime($g['tanggal_lahir']));
        $usia = date('Y') - date('Y', strtotime($g['tanggal_lahir']));
      ?>
      <div class="col-md-4 col-sm-6 mb-3">
        <div class="card <?= $isToday ? 'border-danger' : '' ?>">
          <div class="card-body d-flex align-items-center">

            <img src="<?= base_url('uploads/profile/' . ($g['foto'] ?: 'default.png')) ?>"
                 class="img-circle elevation-2 mr-3"
                 style="width:60px;height:60px;object-fit:cover">

            <div class="flex-grow-1">
              <div class="font-weight-bold">
                <?= esc(trim($g['nama_depan'].' '.$g['nama_belakang'])) ?>
              </div>
              <div class="text-muted small">
                🎉 <?= date('d M', strtotime($g['tanggal_lahir'])) ?>
              </div>
            </div>

            <span class="badge badge-dark"><?= $usia ?></span>
          </div>

          <?php if ($isToday): ?>
            <div class="badge badge-danger position-absolute" style="top:10px;right:10px">
              🎂 HBD TODAY
            </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

</div>
</section>

<?= $this->endSection() ?>
