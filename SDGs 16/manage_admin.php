<?php
session_start();

// Cek apakah admin sudah login dan memiliki role admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] != 'admin') {
    header("Location: admin_loginadmin.php");
    exit();
}

require_once 'koneksi.php';

// Ambil semua admin
$query = "SELECT * FROM admin";
$result = $conn->query($query);

// Cek jika query gagal
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2C3E50;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2C3E50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-buttons a {
            text-decoration: none;
            color: #1ABC9C;
            font-weight: 500;
            margin-right: 10px;
        }
        .action-buttons a:hover {
            color: #16A085;
        }
        .back-button {
            display: inline-block;
            background-color: #E74C3C;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
        .back-button:hover {
            background-color: #C0392B;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Kelola Admin</h2>

    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($admin = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['email']); ?></td>
                    <td class="action-buttons">
                        <a href="edit_admin.php?id=<?= $admin['id']; ?>">Edit</a>
                        <a href="hapus_admin.php?id=<?= $admin['id']; ?>" onclick="return confirm('Yakin ingin menghapus admin ini?');">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboardadmin.php" class="back-button">Kembali ke Dashboard</a>
</div>

</body>
</html>

<?php $conn->close(); ?>
