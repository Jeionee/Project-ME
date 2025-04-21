<?php
session_start();
session_unset(); // Menghapus semua session
session_destroy(); // Menghancurkan session
header("Location: admin_loginadmin.php"); // Redirect ke login
exit();
?>
