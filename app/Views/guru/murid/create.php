<form method="post" enctype="multipart/form-data">

<input name="nama_depan" class="form-control mb-2" placeholder="Nama Depan" required>
<input name="nama_belakang" class="form-control mb-2" placeholder="Nama Belakang">
<select name="kelas_id" class="form-control mb-2">
<option value="1">PG</option>
<option value="2">TKA</option>
<option value="3">TKB</option>
<option value="4">1</option>
<option value="5">2</option>
<option value="6">3</option>
<option value="7">4</option>
<option value="8">5</option>
<option value="9">6</option>
</select>

<textarea name="alamat" class="form-control mb-2" placeholder="Alamat"></textarea>

<input name="no_hp" class="form-control mb-2" placeholder="No HP Orang Tua">

<input type="file" name="foto"
       class="form-control"
       accept="image/*"
       capture="environment">

<button class="btn btn-success btn-block mt-3">
Simpan Murid
</button>
</form>
