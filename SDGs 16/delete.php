<?php
$host = "localhost";
$user = "root";
$pass = "";
$database = "petisi";

$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

$id = $_GET['id'] ?? '';
if ($id) {
  $stmt = $conn->prepare("DELETE FROM dukungan WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

header("Location: lihat.php");
exit;
?>
