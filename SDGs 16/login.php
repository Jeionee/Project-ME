<!-- Halaman Login -->
<?php
session_start();
require_once 'config.php'; // Pastikan koneksi ke database sudah benar

$error = '';

if (isset($_POST['login'])) {
    // Ambil email dan password
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php'); // Redirect ke halaman utama setelah login berhasil
            exit;
        } else {
            $error = "Email atau password salah!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Petisi Mahasiswa</title>
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

<!-- Form Login -->
<section class="py-16 px-6 max-w-md mx-auto bg-white rounded-lg shadow-lg mt-20">
    <h2 class="text-2xl font-bold mb-6 text-center">Masuk ke Petisi Mahasiswa</h2>

    <?php if ($error): ?>
        <div class="p-4 bg-red-100 text-red-800 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php" class="space-y-4">
        <div>
            <label for="email" class="block text-sm font-semibold">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Masukkan email" required>
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded" placeholder="Masukkan password" required>
        </div>
        <button type="submit" name="login" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-full hover:bg-red-700 transition w-full">Masuk</button>
    </form>

    <div class="mt-4 text-center">
        <p class="text-sm">Belum punya akun? <a href="register.php" class="text-red-600 font-semibold">Daftar di sini</a></p>
    </div>
</section>

</body>
</html>
