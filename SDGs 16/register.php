<?php
session_start();
require_once 'config.php'; // Pastikan koneksi ke database sudah benar

$error = $success = '';

if (isset($_POST['register'])) {
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid";
    } elseif ($password !== $password_confirm) {
        $error = "Password dan konfirmasi password tidak cocok";
    } else {
        // Hash password untuk keamanan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar. Coba login atau gunakan email lain.";
        } else {
            // Menyimpan data pengguna baru ke database
            $stmt = $conn->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Pendaftaran berhasil! Silakan login.";
                header('Location: login.php'); // Redirect ke halaman login setelah registrasi berhasil
                exit;
            } else {
                $error = "Terjadi kesalahan saat mendaftar!";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Petisi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<!-- Header -->
<header class="bg-red-600 text-white py-4 fixed w-full z-10 top-0 left-0">
    <div class="max-w-6xl mx-auto flex justify-between items-center px-4">
        <div class="text-lg font-semibold">
            <a href="index.php" class="text-white">Petisi Mahasiswa</a>
        </div>
    </div>
</header>

<!-- Form Registrasi -->
<section class="py-16 px-6 max-w-md mx-auto bg-white rounded-lg shadow-lg mt-20">
    <h2 class="text-2xl font-bold mb-6 text-center">Daftar untuk Petisi Mahasiswa</h2>

    <?php if ($error): ?>
        <div class="p-4 bg-red-100 text-red-800 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="p-4 bg-green-100 text-green-800 rounded mb-4">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php" class="space-y-4">
        <div>
            <label for="nama" class="block text-sm font-semibold">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Nama Lengkap" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-semibold">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Email" required>
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Password" required>
        </div>
        <div>
            <label for="password_confirm" class="block text-sm font-semibold">Konfirmasi Password</label>
            <input type="password" id="password_confirm" name="password_confirm" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Konfirmasi Password" required>
        </div>
        <button type="submit" name="register" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-full hover:bg-red-700 transition w-full">Daftar</button>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm">Sudah punya akun? <a href="login.php" class="text-red-600 font-semibold">Login di sini</a></p>
    </div>
</section>

</body>
</html>
