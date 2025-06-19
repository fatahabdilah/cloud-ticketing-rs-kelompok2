<?php
// File: api/auth/handle_reset_password.php
require_once '../../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

$token = $data['token'] ?? '';
$newPassword = $data['newPassword'] ?? '';
$confirmPassword = $data['confirmPassword'] ?? '';

if (empty($token) || empty($newPassword) || empty($confirmPassword)) {
    json_response(['message' => 'Semua field wajib diisi.'], 400);
}

if ($newPassword !== $confirmPassword) {
    json_response(['message' => 'Password tidak cocok.'], 400);
}

$token_hash = hash('sha256', $token);

// Cek token di database
$stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token_hash);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    json_response(['message' => 'Token reset tidak valid.'], 400);
}

$row = $result->fetch_assoc();
if (strtotime($row['expires_at']) < time()) {
    json_response(['message' => 'Token reset sudah kedaluwarsa.'], 400);
}

$email = $row['email'];

// Update password di tabel users
$hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_password, $email);
if ($stmt->execute()) {
    // Hapus token yang sudah dipakai
    $stmt_delete = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
    $stmt_delete->bind_param("s", $email);
    $stmt_delete->execute();

    json_response(['message' => 'Password berhasil direset.']);
} else {
    json_response(['message' => 'Gagal mereset password.'], 500);
}

$conn->close();
?>