<?php
require_once 'koneksi.php';

$berhasil = $error = '';

// Tangani form submit
if (isset($_POST['submit'])) {
  // Validasi input
  $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $pesan = filter_input(INPUT_POST, 'pesan', FILTER_SANITIZE_STRING);
  
  // Validasi email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Format email tidak valid";
  } else {
    // Siapkan statement
    $stmt = $conn->prepare("INSERT INTO pengisi (nama, email, pesan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $email, $pesan);

    if ($stmt->execute()) {
      $berhasil = true;
    } else {
      $error = $stmt->error;
    }

    $stmt->close();
  }
}
?>
<?php include 'header.php'; ?>

  <!-- Hero Section -->
  <section class="bg-red-600 text-white py-20 px-6 text-center">
    <h1 class="text-4xl md:text-4.5xl font-bold mb-6">"Satu suara mungkin tak terdengar, tapi seribu suara mahasiswa bisa menggetarkan kebijakan.</h1>
    <p class="text-xl md:text-2xl mb-4">Mari bergabung dalam forum ini dan jadi bagian dari gerakan nasional yang mendorong perubahan."</p>
    <a href="#form" class="bg-white text-red-600 font-semibold py-2 px-6 rounded-full hover:bg-gray-100 transition">Tandatangani Petisi</a>
  </section>

  <!-- Tentang Petisi -->
  <section class="py-12 px-6 max-w-4xl mx-auto text-center">
    <h2 class="text-2xl font-bold mb-6 text-center">Tentang Petisi</h2>
    <p class="text-xl mb-4">Petisi merupakan salah satu cara damai untuk menyampaikan aspirasi kepada pengambil kebijakan. Dengan petisi, masyarakat bisa bersatu menyuarakan kepedulian terhadap suatu isu, serta mendorong lahirnya perubahan yang lebih baik.</p>
    <p class="text-xl">Petisi menjadi alat penting untuk memperkuat demokrasi, menuntut perlakuan yang adil, serta mendorong terciptanya lembaga yang lebih terbuka dan bertanggung jawab.</p>
  </section>

  <!-- Berita Terkini -->
  <section class="bg-white py-12 px-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Berita Terkini</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- Berita 1 -->
      <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
        <div class="p-4">
          <p class="text-sm text-gray-500 mb-2">14 April 2025</p>
          <h3 class="font-bold mb-2">Eks Ketua Dewan Mahasiswa Fakultas Sains UIN Malang Diduga Memperkosa Mahasiswa UB</h3>
          <p class="text-sm text-gray-600 mb-3">Pemerkosaan oleh eks Ketua Dewan Mahasiswa UIN Malang itu terjadi pada pekan kedua April di rumah kontrakan terduga pelaku.</p>
          <a href="https://www.tempo.co/hukum/eks-ketua-dewan-mahasiswa-fakultas-sains-uin-malang-diduga-memperkosa-mahasiswa-ub--1231100" class="text-red-600 text-sm font-semibold hover:text-red-700">Baca selengkapnya →</a>
        </div>
      </div>
      
      <!-- Berita 2 -->
      <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
        <div class="p-4">
          <p class="text-sm text-gray-500 mb-2">12 Maret 2024</p>
          <h3 class="font-bold mb-2">Kolaborasi Perguruan Tinggi dalam Pencegahan Radikalisme</h3>
          <p class="text-sm text-gray-600 mb-3">Lima perguruan tinggi terkemuka menandatangani kesepakatan untuk bersama-sama mencegah penyebaran paham radikal...</p>
          <a href="#" class="text-red-600 text-sm font-semibold hover:text-red-700">Baca selengkapnya →</a>
        </div>
      </div>
      
      <!-- Berita 3 -->
      <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
        <div class="p-4">
          <p class="text-sm text-gray-500 mb-2">10 Maret 2024</p>
          <h3 class="font-bold mb-2">Forum Orang Tua Aktif Dalam Pencegahan Radikalisme</h3>
          <p class="text-sm text-gray-600 mb-3">Forum Orang Tua Peduli mengadakan workshop nasional tentang peran keluarga dalam mencegah radikalisme pada anak...</p>
          <a href="#" class="text-red-600 text-sm font-semibold hover:text-red-700">Baca selengkapnya →</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Formulir Tanda Tangan -->
  <section id="form" class="bg-gray-100 py-12 px-6 max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">Tandatangani Petisi</h2>
    <form method="post" action="#form" class="space-y-4">
      <input type="text" name="nama" placeholder="Nama Anda" class="w-full px-4 py-2 border border-gray-300 rounded" required>
      <input type="email" name="email" placeholder="Email Anda" class="w-full px-4 py-2 border border-gray-300 rounded" required>
      <textarea name="pesan" placeholder="Pesan dukungan (opsional)" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded"></textarea>
      <label class="inline-flex items-center">
        <input type="checkbox" name="share" class="form-checkbox text-red-600">
        <span class="">Saya ingin menyebarkan petisi ini</span>
      </label>
      <button type="submit" name="submit" class="bg-red-600 text-white font-semibold py-2 px-6 rounded hover:bg-red-700 transition text-center">Kirim Dukungan</button>
    </form>

    <?php if ($berhasil): ?>
      <div class='mt-6 p-4 bg-green-100 text-green-800 rounded'>
        Terima kasih <?= htmlspecialchars($nama) ?> atas dukunganmu!
      </div>
    <?php elseif ($error): ?>
      <div class='mt-6 p-4 bg-red-100 text-red-800 rounded'>
        Terjadi kesalahan: <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- Footer -->
  <footer class="text-center py-6 text-sm text-gray-500">
    &copy; 2025 Dibuat oleh Kelompok 7
  </footer>

</body>
</html>
<?php
// Tutup koneksi setelah semua operasi selesai
$conn->close();
?>
