<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['user_email'])) {
    header("Location: admin_loginadmin.php");
    exit();
}

// Ambil email admin dari session
$email_user = $_SESSION['user_email'];

// Koneksi ke database
require_once 'koneksi.php';

// Ambil semua data dari tabel pengisi
$query = "SELECT * FROM pengisi ORDER BY id DESC";
$result = $conn->query($query);

// Ambil daftar email unik dari pengisi
$emailQuery = "SELECT DISTINCT email FROM pengisi";
$emailResult = $conn->query($emailQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Petisi Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: #f4f6f8;
            color: #333;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 240px;
            background-color: #2C3E50;
            color: #fff;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            text-decoration: none;
            color: #fff;
            padding: 12px;
            display: block;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #34495E;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #1ABC9C;
        }
        .sidebar .logout-btn {
            margin-top: auto;
            background-color: #E74C3C;
        }

        .main-content {
            flex: 1;
            padding: 30px;
        }
        .header {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .section {
            margin-top: 30px;
        }
        .section h3 {
            margin-bottom: 15px;
            color: #2C3E50;
        }
        .data-list {
            list-style: none;
            padding: 0;
        }
        .data-list li {
            background: #fff;
            margin-bottom: 10px;
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .action-buttons a {
            text-decoration: none;
            margin-left: 15px;
            color: #1ABC9C;
            font-weight: 500;
        }
        .action-buttons a:hover {
            color: #16A085;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="dashboardadmin.php">Dashboard</a>
        <a href="manage_admin.php">Manage Admin</a> <!-- Perbaiki link menuju Manage Admin -->
        <a href="logout_admin.php" class="logout-btn">Logout</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Selamat Datang, <?= htmlspecialchars($email_user) ?></h1>
            <p>Anda sedang berada di dashboard admin petisi mahasiswa.</p>
        </div>

        <!-- Data Petisi -->
        <div class="section">
            <h3>Daftar Pengisi Petisi</h3>
            <ul class="data-list">
                <?php while ($row = $result->fetch_assoc()) : ?>
                <li>
                    <span><?= htmlspecialchars($row['nama']) ?> - <?= htmlspecialchars($row['email']) ?></span>
                    <div class="action-buttons">
                        <a href="edit_petisiadmin.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="hapus_petisiadmin.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus petisi ini?')">Hapus</a>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Daftar Email Pendukung -->
        <div class="section" id="akun-section">
            <h3>Daftar Email Pendukung</h3>
            <ul class="data-list">
                <?php if ($emailResult->num_rows > 0): ?>
                    <?php while ($row = $emailResult->fetch_assoc()) : ?>
                    <li>
                        <span><?= htmlspecialchars($row['email']) ?></span>
                        <div class="action-buttons">
                            <a href="hapus_emailadmin.php?email=<?= urlencode($row['email']) ?>" onclick="return confirm('Yakin ingin menghapus semua petisi dari email ini?')">Hapus Semua</a>
                        </div>
                    </li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li><span>Belum ada data pendukung petisi.</span></li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
