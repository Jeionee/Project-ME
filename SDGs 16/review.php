<?php
session_start();
include 'config.php';

$reviews = [];
$error = '';

// Mengambil data pengisi petisi dari database
$sql = "SELECT * FROM pengisi";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Menyensor nama pengisi petisi
        $row['nama'] = substr($row['nama'], 0, 1) . str_repeat('*', strlen($row['nama']) - 1);

        // Menyensor email pengisi petisi
        $email_parts = explode('@', $row['email']);
        $email_parts[0] = substr($email_parts[0], 0, 2) . str_repeat('*', strlen($email_parts[0]) - 2);
        $row['email'] = implode('@', $email_parts);

        $reviews[] = $row;
    }
} else {
    $error = "Tidak ada data petisi.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Petisi</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-gradient-to-r from-red-500 to-red-600 text-white py-4 fixed w-full z-10 top-0 left-0">
    <div class="max-w-6xl mx-auto flex justify-between items-center px-6">
        <div class="text-lg font-semibold">
            <a href="index.php" class="text-white">Petisi Mahasiswa</a>
        </div>
        <div>
            <a href="index.php" class="bg-white text-red-600 font-semibold py-2 px-4 rounded-full hover:bg-gray-200">Kembali ke Halaman Utama</a>
        </div>
    </div>
</header>

<!-- Review Section -->
<section class="py-16 px-6 bg-white mt-20">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-4xl font-bold text-center text-gray-900 mb-10">Review Petisi</h2>

    <?php if ($error): ?>
      <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6 text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <!-- Tabel Review Pengisi Petisi -->
    <div class="overflow-x-auto shadow-lg rounded-lg">
      <table class="min-w-full table-auto">
        <thead class="bg-red-600 text-white">
            <tr>
                <th class="py-3 px-6 text-left">Nama</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-left">Pesan Dukungan</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            <?php foreach ($reviews as $review): ?>
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-6 border-t"><?= htmlspecialchars($review['nama']) ?></td>
                    <td class="py-3 px-6 border-t"><?= htmlspecialchars($review['email']) ?></td>
                    <td class="py-3 px-6 border-t"><?= htmlspecialchars($review['pesan']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<footer class="text-center py-6 text-sm text-gray-500 bg-white mt-10 border-t">
  &copy; 2025 Forum Petisi Mahasiswa. All rights reserved.
</footer>

</body>
</html>
