<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h3 class="mb-3">Absensi Hari Ini</h3>

<?php if(session('success')): ?>
<div class="alert alert-success"><?= session('success') ?></div>
<?php endif ?>

<?php if(!$absensi): ?>
<div class="alert alert-info">
Belum ada absensi hari ini.
</div>

<div class="mt-3">
    <a href="<?= base_url('dashboard/guru') ?>" class="btn btn-secondary mr-2">
        ⬅️ Kembali ke Dashboard
    </a>
    <a href="<?= base_url('guru/absensi') ?>" class="btn btn-primary">
        ⬅️ Kembali ke Absensi
    </a>
</div>

<?= $this->endSection() ?>
<?php return; endif ?>

<?php
$sisa = max(0, 3600 - (time() - strtotime($absensi->created_at)));
?>

<?php if($sisa <= 0): ?>
<div class="alert alert-warning">
⏱️ Waktu edit telah habis. Absensi bersifat read-only.
</div>
<?php endif ?>

<form method="post" action="<?= base_url('guru/absensi-hari-ini/simpan') ?>">
<?= csrf_field() ?>

<table class="table table-bordered">
<thead>
<tr>
<th>Nama Murid</th>
<th>Kelas</th>
<th>Status</th>
<th>Edit</th>
</tr>
</thead>
<tbody>

<?php
$label=[1=>'PG',2=>'TKA',3=>'TKB',4=>'1',5=>'2',6=>'3',7=>'4',8=>'5',9=>'6'];
foreach($detail as $d):
$foto = $d['foto'] ?? '';
?>
<tr>
<td>
<span class="text-primary" style="cursor:pointer"
      onclick="showFoto('<?= base_url('uploads/murid/default_murid.png') ?>')">
<?= esc($d['nama_depan'].' '.$d['nama_belakang']) ?>
</span>
</td>
<td><?= $label[$d['kelas_id']] ?></td>
<td>
<?php if($d['status']=='overlap'): ?>
<span class="badge badge-warning">Overlap</span>
<?php elseif($d['status']=='hadir'): ?>
<span class="badge badge-success">Hadir</span>
<?php else: ?>
<span class="badge badge-secondary">Tidak Hadir</span>
<?php endif ?>
</td>
<td>
<input type="hidden" name="detail_id[]" value="<?= $d['id'] ?>">
<?php if($sisa > 0): ?>
<input type="checkbox" name="hadir[]" value="<?= $d['id'] ?>"
<?= $d['status']=='hadir'?'checked':'' ?>>
<?php else: ?>
—
<?php endif ?>
</td>
</tr>
<?php endforeach ?>

</tbody>
</table>

<?php if($sisa > 0): ?>
<button class="btn btn-success mb-3">
💾 Simpan Perubahan
</button>
<?php endif ?>

</form>

<!-- =========================
     TOMBOL NAVIGASI
========================= -->
<div class="mt-4">
    <a href="<?= base_url('dashboard/guru') ?>" class="btn btn-secondary mr-2">
        ⬅️ Kembali ke Dashboard
    </a>
    <a href="<?= base_url('guru/absensi') ?>" class="btn btn-primary">
        ⬅️ Kembali ke Absensi
    </a>
</div>

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
    if(!src || src.endsWith('/')){
        alert('Foto murid belum tersedia');
        return;
    }
    document.getElementById('fotoPreview').src = src;
    document.getElementById('fotoOverlay').style.display = 'flex';
}
</script>

<?= $this->endSection() ?>
