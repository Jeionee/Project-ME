<?php
require_once 'koneksi.php';

// Admin default
$email = "rifqiadiyatma55@gmail.com";
$password_plain = "1234";
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

// Cek apakah admin sudah ada
$query_check = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($query_check);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Admin dengan email tersebut sudah ada.";
} else {
    // Tambahkan admin baru
    $query_insert = "INSERT INTO admin (email, password) VALUES (?, ?)";
    $stmt = $conn->prepare($query_insert);
    $stmt->bind_param("ss", $email, $password_hashed);
    
    if ($stmt->execute()) {
        echo "Admin berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan admin: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>
