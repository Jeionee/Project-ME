<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_email'])) {
    header("Location: admin_loginadmin.php");
    exit();
}

// Koneksi ke database
require_once 'koneksi.php';

// Cek apakah ada parameter ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data petisi berdasarkan ID
    $query = "SELECT * FROM pengisi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Petisi tidak ditemukan.");
    }

    $petisi = $result->fetch_assoc();
} else {
    die("ID petisi tidak ditemukan.");
}

// Proses update data petisi jika form disubmit
if (isset($_POST['submit'])) {
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $pesan = filter_input(INPUT_POST, 'pesan', FILTER_SANITIZE_STRING);

    // Update data petisi di database
    $updateQuery = "UPDATE pengisi SET nama = ?, email = ?, pesan = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssi", $nama, $email, $pesan, $id);

    if ($updateStmt->execute()) {
        $success = "Petisi berhasil diperbarui.";
    } else {
        $error = "Terjadi kesalahan saat memperbarui data: " . $updateStmt->error;
    }
}

// Proses hapus data petisi jika tombol hapus ditekan
if (isset($_POST['hapus'])) {
    // Hapus data petisi dari database
    $deleteQuery = "DELETE FROM pengisi WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
        header("Location: manage_petisi.php"); // Redirect ke halaman manage petisi setelah berhasil dihapus
        exit();
    } else {
        $error = "Terjadi kesalahan saat menghapus data: " . $deleteStmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Petisi Admin</title>
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
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #2C3E50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #34495E;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group button {
            background-color: #1ABC9C;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #16A085;
        }
        .button-back {
            background-color: #E74C3C;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            text-decoration: none;
        }
        .button-back:hover {
            background-color: #C0392B;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        <h1>Edit Petisi</h1>
        <p>Sesuaikan data petisi yang ingin Anda ubah.</p>
    </div>

    <!-- Form Edit Petisi -->
    <div class="form-container">
        <h2>Edit Petisi #<?= htmlspecialchars($petisi['id']) ?></h2>

        <!-- Success or Error Message -->
        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 20px; text-align: center;">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div style="color: red; margin-bottom: 20px; text-align: center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Form untuk Mengedit Petisi -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($petisi['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($petisi['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="pesan">Pesan</label>
                <textarea id="pesan" name="pesan" rows="5" required><?= htmlspecialchars($petisi['pesan']) ?></textarea>
            </div>

            <div class="form-group">
                <button type="submit" name="submit">Update Petisi</button>
            </div>
        </form>

        <!-- Tombol Hapus Petisi -->
        <form method="POST" action="">
            <div class="form-group" style="text-align: center;">
                <button type="submit" name="hapus" style="background-color: #E74C3C; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer;">Hapus Petisi</button>
            </div>
        </form>

        <!-- Button Kembali ke Dashboard -->
        <a href="dashboardadmin.php" class="button-back">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>

<?php
// Tutup koneksi setelah selesai
$conn->close();
?>
