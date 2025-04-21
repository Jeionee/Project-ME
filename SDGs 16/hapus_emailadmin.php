<?php
require_once 'koneksi.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $stmt = $conn->prepare("DELETE FROM pengisi WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: dashboardadmin.php");
exit();
