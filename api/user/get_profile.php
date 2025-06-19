<?php
// File: api/user/get_profile.php
require_once '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    json_response(['message' => 'Unauthorized'], 401);
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nama_lengkap, email, no_telepon FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

json_response($profile);
$stmt->close();
$conn->close();
?>