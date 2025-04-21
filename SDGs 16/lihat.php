<?php
// koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$database  = "petisi";

$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// ambil semua data dukungan
$sql = "SELECT * FROM dukungan ORDER BY tanggal_dibuat DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Dukungan Petisi</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
  <section class="max-w-6xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Daftar Dukungan Petisi</h1>
    
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200 rounded shadow">
        <thead>
          <tr class="bg-gray-100 text-left">
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Nama</th>
            <th class="px-4 py-2 border">Email</th>
            <th class="px-4 py-2 border">Pesan</th>
            <th class="px-4 py-2 border">Share</th>
            <th class="px-4 py-2 border">Tanggal</th>
            <th class="px-4 py-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border"><?= $no++ ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['email']) ?></td>
                <td class="px-4 py-2 border"><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
                <td class="px-4 py-2 border"><?= $row['share'] ?></td>
                <td class="px-4 py-2 border"><?= $row['tanggal_dibuat'] ?></td>
                <td class="px-4 py-2 border space-x-2">
                  <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                  <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center px-4 py-4 text-gray-500">Belum ada dukungan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="text-center mt-6">
      <a href="index.php" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Kembali ke Form Petisi</a>
    </div>
  </section>
</body>
</html>
<?php $conn->close(); ?>
