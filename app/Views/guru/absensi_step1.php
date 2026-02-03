<?= $this->extend('layouts/adminlte') ?>
<?= $this->section('content') ?>

<h3 class="mb-3">Absensi Sekolah Minggu</h3>

<div class="card">
<div class="card-body">

<form method="get" action="<?= base_url('guru/absensi/tampilkan') ?>" onsubmit="return validateForm()">

<div class="mb-3">
<strong>Pilih Kelas</strong><br>
<?php
$kelas = [
  1=>'PG',2=>'TKA',3=>'TKB',
  4=>'1',5=>'2',6=>'3',
  7=>'4',8=>'5',9=>'6'
];
foreach($kelas as $id=>$n):
?>
<label class="mr-3">
<input type="checkbox" name="kelas[]" value="<?= $id ?>"> <?= $n ?>
</label>
<?php endforeach ?>
</div>

<div class="mb-3">
<strong>Lokasi</strong>
<select name="lokasi" id="lokasi" class="form-control" style="max-width:300px">
<option value="">-- pilih lokasi --</option>
<option value="NICC">NICC</option>
<option value="GRASA">GRASA</option>
<option value="CPM">CPM</option>
</select>
</div>

<button class="btn btn-success btn-lg">
➡️ Lanjut Absensi
</button>

</form>

</div>
</div>

<?php
$konflik = session('absensi_konflik');
if ($konflik):
session()->remove('absensi_konflik');
?>

<!-- =========================
     POPUP KONFLIK
========================== -->
<div class="modal fade show" id="modalKonflik" style="display:block;background:rgba(0,0,0,.5)">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title">⚠️ Potensi Konflik Absensi</h5>
      </div>

      <div class="modal-body">
        <p>Beberapa murid sudah diabsen oleh guru lain di lokasi berbeda:</p>

        <ul>
        <?php foreach($konflik as $k): ?>
          <li>
            <strong><?= esc($k['murid']) ?></strong>
            <br>
            Sudah diabsen oleh <strong>Kak <?= esc($k['guru']) ?></strong>
          </li>
        <?php endforeach ?>
        </ul>

        <div class="alert alert-info mt-3">
          Silakan koordinasi dengan guru terkait.  
          Absensi dapat diperbaiki melalui menu <strong>Absensi Hari Ini</strong> (≤ 1 jam).
        </div>
      </div>

      <div class="modal-footer">
        <a href="<?= base_url('guru/absensi-hari-ini') ?>" class="btn btn-outline-primary">
          🔍 Lihat Detail
        </a>
        <button class="btn btn-secondary" onclick="document.getElementById('modalKonflik').style.display='none'">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>

<?php endif ?>

<script>
function validateForm(){
    const k = document.querySelectorAll('input[name="kelas[]"]:checked').length;
    const l = document.getElementById('lokasi').value;
    if(!k || !l){
        alert('Kelas dan lokasi wajib dipilih');
        return false;
    }
    return true;
}
</script>

<?= $this->endSection() ?>
