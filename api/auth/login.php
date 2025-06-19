<?php
// File: api/auth/login.php
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($email) || empty($password)) {
        json_response(['message' => 'Email dan password wajib diisi.'], 400);
    }

    $stmt = $conn->prepare("SELECT id, nama_lengkap, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nama_lengkap'];
            json_response(['message' => 'Login berhasil.']);
        } else {
            json_response(['message' => 'Password salah.'], 401);
        }
    } else {
        json_response(['message' => 'Email tidak ditemukan.'], 404);
    }
    $stmt->close();
}
$conn->close();
?>