<h2>Reset Password</h2>

<form method="post" action="/reset-password">
    <input type="hidden" name="token" value="<?= esc($token) ?>">
    <input type="password" name="password" placeholder="Password Baru" required>
    <button type="submit">Simpan Password</button>
</form>
