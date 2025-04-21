<?php
session_start();
include 'config.php'; // koneksi ke database

$berhasil = '';
$error = '';
$isLoggedIn = isset($_SESSION['user']);

// Tangani form petisi
if (isset($_POST['submit']) && $isLoggedIn) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $pesan = trim($_POST['pesan']);

    if ($nama && $email) {
        $stmt = $conn->prepare("INSERT INTO pengisi (nama, email, pesan) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $pesan);

        if ($stmt->execute()) {
            $berhasil = "Dukungan berhasil dikirim!";
        } else {
            $error = "Gagal menyimpan dukungan. Silakan coba lagi.";
        }

        $stmt->close();
    } else {
        $error = "Nama dan email wajib diisi.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petisi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-red-600 text-white py-4 fixed w-full z-10 top-0 left-0">
    <div class="max-w-6xl mx-auto flex justify-between items-center px-4">
        <div class="text-lg font-semibold">
            <a href="index.php" class="text-white">Petisi Mahasiswa</a>
        </div>
        <div>
            <?php if (!$isLoggedIn): ?>
                <a href="login.php" class="text-white font-semibold py-2 px-4 rounded-full hover:bg-red-700">Login</a>
                <a href="register.php" class="text-white font-semibold py-2 px-4 rounded-full hover:bg-red-700 ml-4">Daftar</a>
            <?php else: ?>
                <span class="text-white font-semibold">Hello, <?= htmlspecialchars($_SESSION['user']['nama']) ?></span>
                <a href="logout.php" class="text-white font-semibold py-2 px-4 rounded-full hover:bg-red-700 ml-4">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="bg-red-600 text-white py-20 text-center mt-20">
  <div class="max-w-4xl mx-auto px-4">
    <h1 class="text-4xl md:text-5xl font-bold mb-6">"Satu suara mahasiswa mungkin terdengar kecil. Tapi ribuan suara dapat mengguncang sistem."</h1>
    <p class="text-xl mb-6">Gabung dalam gerakan kolektif yang memperjuangkan keadilan, transparansi, dan perubahan kebijakan demi masa depan bangsa.</p>
    <a href="#form" class="bg-white text-red-600 font-semibold py-2 px-6 rounded-full hover:bg-gray-200 transition">Tandatangani Petisi</a>
  </div>
</section>

<!-- Tentang Petisi -->
<section class="py-16 bg-gray-50 px-6">
  <div class="max-w-3xl mx-auto text-center">
    <h2 class="text-3xl font-bold mb-6">Mengapa Petisi Ini Penting?</h2>
    <p class="text-lg mb-4">Petisi ini adalah suara kita bersama. Ketika mahasiswa bersatu, kita bisa menjadi kekuatan yang mampu mendorong perubahan. Kami menuntut keadilan, perlindungan terhadap korban, dan tindakan nyata dari lembaga kampus terhadap segala bentuk kekerasan dan ketidakadilan.</p>
    <p class="text-lg">Dengan menandatangani, kamu bukan hanya memberikan dukungan—kamu menjadi bagian dari gerakan perubahan yang lebih besar.</p>
  </div>
</section>

<!-- Berita Terkini -->
<section class="py-16 px-6 bg-white">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-3xl font-bold text-center mb-10">Berita Terkini</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Berita 1 -->
      <div class="bg-gray-100 rounded shadow hover:shadow-lg p-5">
        <p class="text-sm text-gray-500 mb-2">14 April 2025</p>
        <h3 class="font-bold mb-2">Eks Ketua Dewan Mahasiswa Fakultas Sains UIN Malang Dikeluarkan dari Kampus</h3>
        <p class="text-sm text-gray-700">Eks Ketua Dewan Eksekutif Mahasiswa Fakultas Sains dan Teknologi Universitas Islam Negeri (UIN) Maulana Malik Ibrahim Malang berinisial IPF yang diduga melakukan kekerasan seksual diberhentikan...</p>
        <a href="https://www.tempo.co/hukum/eks-ketua-dewan-mahasiswa-fakultas-sains-uin-malang-dikeluarkan-dari-kampus-1231963" class="text-red-600 text-sm font-semibold hover:text-red-700 mt-2 inline-block">Baca selengkapnya →</a>
      </div>
      <!-- Berita 2 -->
      <div class="bg-gray-100 rounded shadow hover:shadow-lg p-5">
        <p class="text-sm text-gray-500 mb-2">12 Maret 2024</p>
        <h3 class="font-bold mb-2">Kolaborasi Kampus Lawan Radikalisme</h3>
        <p class="text-sm text-gray-700">Perguruan tinggi Indonesia membentuk koalisi nasional untuk mencegah radikalisme dan menciptakan lingkungan akademik yang sehat...</p>
        <a href="#" class="text-red-600 text-sm font-semibold hover:text-red-700 mt-2 inline-block">Baca selengkapnya →</a>
      </div>
      <!-- Berita 3 -->
      <div class="bg-gray-100 rounded shadow hover:shadow-lg p-5">
        <p class="text-sm text-gray-500 mb-2">10 Maret 2024</p>
        <h3 class="font-bold mb-2">Peran Keluarga Dalam Cegah Ekstremisme di Kampus</h3>
        <p class="text-sm text-gray-700">Forum nasional orang tua mahasiswa membahas pentingnya komunikasi dan dukungan moral dari rumah...</p>
        <a href="#" class="text-red-600 text-sm font-semibold hover:text-red-700 mt-2 inline-block">Baca selengkapnya →</a>
      </div>
    </div>
  </div>
</section>

<!-- Form Petisi -->
<section id="form" class="bg-gray-50 py-16 px-6">
  <div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Tandatangani Petisi Ini</h2>

    <?php if ($error): ?>
      <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-6 text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <?php if ($berhasil): ?>
      <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center">
        <?= htmlspecialchars($berhasil) ?>
      </div>
    <?php endif; ?>

    <?php if ($isLoggedIn): ?>
      <form method="post" action="#form" class="space-y-4">
        <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full px-4 py-2 border rounded" required>
        <input type="email" name="email" placeholder="Email Aktif" class="w-full px-4 py-2 border rounded" required>
        <textarea name="pesan" placeholder="Pesan Dukungan (opsional)" rows="4" class="w-full px-4 py-2 border rounded"></textarea>
        <div class="flex justify-between">
          <button type="submit" name="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition w-1/2 mr-2">Kirim Dukungan</button>
          <a href="review.php" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition w-1/2 ml-2 text-center">Review Petisi</a>
        </div>
      </form>
    <?php else: ?>
      <div class="text-center mb-6">
        <a href="login.php" class="text-red-600 font-semibold">Login atau Daftar untuk memberi dukungan</a>
      </div>
    <?php endif; ?>
  </div>
</section>

<footer class="text-center py-6 text-sm text-gray-500 bg-white mt-10 border-t">
  &copy; 2025 Forum Petisi Mahasiswa. All rights reserved.
</footer>

</body>
</html>