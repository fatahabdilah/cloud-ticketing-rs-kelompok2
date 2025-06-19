<?php
// File: api/user/cancel_ticket.php
// API ini menangani logika untuk membatalkan tiket antrian.

require_once '../../config/database.php';

// 1. Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    json_response(['message' => 'Akses ditolak. Anda harus login terlebih dahulu.'], 401);
}

// 2. Pastikan metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['message' => 'Metode request tidak valid.'], 405);
}

// 3. Ambil data dari body request
$data = json_decode(file_get_contents('php://input'), true);
$nomor_antrian = $data['nomor_antrian'] ?? '';
$id_user = $_SESSION['user_id'];

if (empty($nomor_antrian)) {
    json_response(['message' => 'Nomor antrian tidak boleh kosong.'], 400);
}

// 4. Update status tiket di database
// Query ini hanya akan berhasil jika:
// - Nomor antrian cocok
// - ID user cocok (pengguna hanya bisa membatalkan tiket miliknya sendiri)
// - Status tiket adalah 'Menunggu' (tiket yang sudah selesai/kadaluarsa tidak bisa dibatalkan)
$stmt = $conn->prepare("
    UPDATE antrian
    SET status = 'Batal'
    WHERE nomor_antrian = ? AND id_user = ? AND status = 'Menunggu'
");
$stmt->bind_param("si", $nomor_antrian, $id_user);

if ($stmt->execute()) {
    // 5. Cek apakah ada baris yang terpengaruh
    if ($stmt->affected_rows > 0) {
        json_response(['message' => 'Tiket ' . $nomor_antrian . ' berhasil dibatalkan.']);
    } else {
        json_response(['message' => 'Gagal membatalkan tiket. Tiket mungkin tidak ditemukan, bukan milik Anda, atau statusnya tidak memungkinkan untuk dibatalkan.'], 404);
    }
} else {
    json_response(['message' => 'Terjadi kesalahan pada server.'], 500);
}

$stmt->close();
$conn->close();
?>