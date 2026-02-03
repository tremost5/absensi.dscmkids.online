<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<style>
.kelas-box{
    border-left:6px solid #28a745;
    margin-bottom:20px;
}
.murid-row{
    display:grid;
    grid-template-columns: 2fr 1fr 1fr;
    padding:8px;
    border-bottom:1px solid #eee;
}
.murid-row.header{
    font-weight:bold;
    background:#f4f6f9;
}
.murid-row:hover{ background:#f9f9f9 }
.nama{
    cursor:pointer;
    color:#007bff;
}
</style>

<h3 class="mb-3">Form Absensi</h3>
<p class="text-muted">Lokasi: <?= esc($lokasi) ?></p>

<div id="notif"></div>

<form id="formAbsensi" enctype="multipart/form-data">
<?= csrf_field() ?>

<?php foreach($kelas as $k): ?>
<input type="hidden" name="kelas[]" value="<?= $k ?>">
<?php endforeach ?>
<input type="hidden" name="lokasi" value="<?= esc($lokasi) ?>">

<?php
$label=[1=>'PG',2=>'TKA',3=>'TKB',4=>'1',5=>'2',6=>'3',7=>'4',8=>'5',9=>'6'];
$group=[];
foreach($murid as $m){ $group[$m['kelas_id']][]=$m; }
$defaultFoto = base_url('uploads/murid/default_murid.png');
?>

<?php foreach($group as $k=>$list): ?>
<div class="card kelas-box">
<div class="card-header bg-success text-white">
Kelas <?= $label[$k] ?>
</div>
<div class="card-body p-0">

<div class="murid-row header">
<div>Nama Murid</div>
<div>Kelas</div>
<div>Hadir</div>
</div>

<?php foreach($list as $m): ?>
<div class="murid-row">
<div class="nama"
     onclick="showFoto('<?= $defaultFoto ?>')">
<?= esc($m['nama_depan'].' '.$m['nama_belakang']) ?>
</div>
<div><?= $label[$k] ?></div>
<div>
<input type="checkbox" name="hadir[]" value="<?= $m['id'] ?>">
</div>
</div>
<?php endforeach ?>

</div>
</div>
<?php endforeach ?>

<div class="card">
<div class="card-body">
<strong>Selfie Guru (Wajib)</strong>
<input type="file" name="selfie" class="form-control" required>

<button id="btnSubmit" type="button"
        class="btn btn-success btn-lg btn-block mt-3">
💾 Simpan Absensi
</button>

<small class="text-muted d-block text-center mt-2">
Pastikan data sudah benar sebelum menyimpan
</small>
</div>
</div>

</form>

<!-- =========================
     OVERLAY PREVIEW FOTO
========================= -->
<div id="fotoOverlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);z-index:1050"
     onclick="this.style.display='none'">
    <img id="fotoPreview"
         style="max-width:85vw;max-height:85vh;margin:auto;display:block">
</div>

<script>
function showFoto(src){
    document.getElementById('fotoPreview').src = src;
    document.getElementById('fotoOverlay').style.display = 'flex';
}

document.getElementById('btnSubmit').addEventListener('click', function(){
    const btn = this;
    const notif = document.getElementById('notif');

    btn.disabled = true;
    btn.innerText = '⏳ Menyimpan...';
    notif.innerHTML = '';

    const formData = new FormData(document.getElementById('formAbsensi'));

    fetch("<?= base_url('guru/absensi/simpan') ?>", {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(r => {
        if (r.status === 'success') {
            notif.innerHTML = `<div class="alert alert-success">✅ ${r.message}</div>`;
            setTimeout(() => {
                window.location.href = "<?= base_url('guru/absensi') ?>";
            }, 1200);
            return;
        }

        notif.innerHTML = `<div class="alert alert-danger">❌ ${r.message}</div>`;
        btn.disabled = false;
        btn.innerText = '💾 Simpan Absensi';
    })
    .catch(() => {
        notif.innerHTML = `<div class="alert alert-danger">❌ Koneksi bermasalah</div>`;
        btn.disabled = false;
        btn.innerText = '💾 Simpan Absensi';
    });
});
</script>

<?= $this->endSection() ?>
