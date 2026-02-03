<?php
$hash = '$PASTE_PASSWORD_DARI_DB_DI_SINI';
echo password_verify('admin123', $hash) ? 'OK' : 'FAIL';
