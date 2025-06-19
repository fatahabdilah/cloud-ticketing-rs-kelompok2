<?php
// File: api/auth/register.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $nama_lengkap = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $no_telepon = $data['phone'] ?? '';

    if (empty($nama_lengkap) || empty($email) || empty($password) || empty($no_telepon)) {
        json_response(['message' => 'Semua field wajib diisi.'], 400);
    }

    // Cek apakah email sudah terdaftar
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        json_response(['message' => 'Email sudah terdaftar.'], 409);
    }
    $stmt_check->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Masukkan user baru ke database
    $stmt_insert = $conn->prepare("INSERT INTO users (nama_lengkap, email, password, no_telepon) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("ssss", $nama_lengkap, $email, $hashed_password, $no_telepon);

    if ($stmt_insert->execute()) {
        json_response(['message' => 'Registrasi berhasil. Silakan masuk.']);
    } else {
        json_response(['message' => 'Registrasi gagal. Coba lagi.'], 500);
    }
    $stmt_insert->close();
}
$conn->close();
?>