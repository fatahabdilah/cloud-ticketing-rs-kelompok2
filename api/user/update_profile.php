<?php
// File: api/user/update_profile.php
require_once '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    json_response(['message' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $_SESSION['user_id'];

    $nama = $data['name'] ?? '';
    $telepon = $data['phone'] ?? '';
    $email = $data['email'] ?? '';
    $newPassword = $data['newPassword'] ?? '';

    // Update data dasar
    $stmt = $conn->prepare("UPDATE users SET nama_lengkap = ?, no_telepon = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nama, $telepon, $email, $user_id);
    $stmt->execute();

    // Jika ada password baru, update password
    if (!empty($newPassword)) {
        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt_pass = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt_pass->bind_param("si", $hashed_password, $user_id);
        $stmt_pass->execute();
    }
    
    json_response(['message' => 'Profil berhasil diperbarui.']);
}
?>