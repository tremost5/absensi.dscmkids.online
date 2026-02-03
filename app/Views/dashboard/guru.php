<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="row mb-3">
        <div class="col-12">
            <h3>Dashboard Guru</h3>
            <p>Selamat mengajar 🙏</p>
        </div>
    </div>

    <div class="row">

        <!-- STATUS GURU -->
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-body">
                    <h6>Status</h6>
                    <h4 id="statusGuru">-</h4>
                </div>
            </div>
        </div>

        <!-- LAST LOGIN -->
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-body">
                    <h6>Login Terakhir</h6>
                    <h4 id="lastLoginGuru">-</h4>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
function loadGuruStatus() {
    fetch("<?= base_url('guru/status') ?>")
        .then(res => res.json())
        .then(res => {
            document.getElementById('statusGuru').innerText = res.status;
            document.getElementById('lastLoginGuru').innerText = res.last_login;
        });
}

loadGuruStatus();
setInterval(loadGuruStatus, 60000);
</script>

<?= $this->endSection() ?>
