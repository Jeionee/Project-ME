<?php
session_start();

// Hapus semua sesi yang ada
session_unset();

// Hancurkan sesi pengguna
session_destroy();

// Arahkan kembali ke halaman utama (index)
header('Location: index.php');
exit;
?>
