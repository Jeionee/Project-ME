<?php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_email'])) {
    header("Location: dashboardadmin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'koneksi.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Ambil data admin berdasarkan email
    $query = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_email'] = $admin['email'];
            $_SESSION['user_role'] = 'admin';
            header("Location: dashboardadmin.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Admin tidak ditemukan!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            text-align: center;
            color: #2C3E50;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #1ABC9C;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #16A085;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .register-link a {
            color: #2980B9;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login Admin</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email Admin</label>
            <input type="email" name="email" id="email" placeholder="Masukkan email..." required>
        </div>
        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" placeholder="Masukkan kata sandi..." required>
        </div>
        <button type="submit">Login</button>
    </form>

    <div class="register-link">
        Belum punya akun? <a href="admin_register.php">Buat akun admin</a>
    </div>
</div>

</body>
</html>
