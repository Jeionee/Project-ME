<?php
require_once 'koneksi.php';

$berhasil = $error = '';

// Tangani form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid";
    }
    // Validasi password
    elseif ($password !== $password_confirm) {
        $error = "Password dan konfirmasi password tidak cocok";
    }
    elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter";
    } else {
        // Hash password
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah email sudah ada
        $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Email sudah terdaftar";
        } else {
            // Menyimpan data admin ke database
            $stmt = $conn->prepare("INSERT INTO admin (email, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $password_hashed);
            if ($stmt->execute()) {
                // Jika berhasil, redirect ke halaman login
                header("Location: admin_loginadmin.php");
                exit();
            } else {
                $error = "Terjadi kesalahan saat mendaftar: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Daftar Admin</h2>

        <?php if (!empty($berhasil)): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                <?= htmlspecialchars($berhasil) ?>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 mb-4 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border rounded" required>
            <input type="password" name="password_confirm" placeholder="Konfirmasi Password" class="w-full p-2 mb-4 border rounded" required>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Daftar</button>
        </form>

        <div class="text-center mt-4 text-sm">
            Sudah punya akun? <a href="admin_loginadmin.php" class="text-blue-600 hover:underline">Login di sini</a>
        </div>
    </div>
</body>
</html>
