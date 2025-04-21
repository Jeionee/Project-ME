<?php
// Koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$database = "petisi";

$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data berdasarkan ID
$id = $_GET['id'] ?? '';
$sql = "SELECT * FROM dukungan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
  echo "Data tidak ditemukan.";
  exit;
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = htmlspecialchars($_POST['nama']);
  $email = htmlspecialchars($_POST['email']);
  $pesan = htmlspecialchars($_POST['pesan']);
  $share = isset($_POST['share']) ? 'Ya' : 'Tidak';

  $sql_update = "UPDATE dukungan SET nama=?, email=?, pesan=?, share=? WHERE id=?";
  $stmt = $conn->prepare($sql_update);
  $stmt->bind_param("ssssi", $nama, $email, $pesan, $share, $id);

  if ($stmt->execute()) {
    header("Location: lihat.php");
    exit;
  } else {
    echo "Gagal update data: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Dukungan</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 py-10 px-4">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Dukungan</h1>
    <form method="post" class="space-y-4">
      <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="w-full px-4 py-2 border rounded" required>
      <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="w-full px-4 py-2 border rounded" required>
      <textarea name="pesan" rows="4" class="w-full px-4 py-2 border rounded"><?= htmlspecialchars($data['pesan']) ?></textarea>
      <label class="inline-flex items-center">
        <input type="checkbox" name="share" class="form-checkbox" <?= $data['share'] === 'Ya' ? 'checked' : '' ?>>
        <span class="ml-2">Saya ingin menyebarkan petisi ini</span>
      </label>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
    </form>
    <div class="mt-4 text-sm">
      <a href="lihat.php" class="text-blue-600 hover:underline">← Kembali ke daftar dukungan</a>
    </div>
  </div>
</body>
</html>
