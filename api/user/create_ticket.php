<?php
// File: api/user/create_ticket.php (Logika Penomoran Informatif per Layanan)
require_once '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    json_response(['message' => 'Unauthorized'], 401);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id_user = $_SESSION['user_id'];
    $id_layanan = $data['service'] ?? 0;
    $id_dokter = $data['doctor'] ?? 0;
    $tanggal_kunjungan = $data['date'] ?? '';
    $jam_kunjungan = $data['time'] ?? '';

    if (empty($id_layanan) || empty($id_dokter) || empty($tanggal_kunjungan) || empty($jam_kunjungan)) {
        json_response(['message' => 'Semua field wajib diisi, termasuk jam kunjungan.'], 400);
    }
    
    // 1. Ambil kode unik layanan dari database 
    $prefix_stmt = $conn->prepare("SELECT kode_layanan as prefix FROM layanan WHERE id = ?");
    $prefix_stmt->bind_param("i", $id_layanan);
    $prefix_stmt->execute();
    $prefix_result = $prefix_stmt->get_result()->fetch_assoc();
    $prefix = $prefix_result['prefix'] ?? 'GEN';


    // ========================================================
    // ==== BAGIAN INI DIPERBARUI UNTUK NOMOR URUT PER LAYANAN ====
    // ========================================================
    // 2. Hitung jumlah antrian berdasarkan TANGGAL dan ID LAYANAN yang spesifik.
    // Ini akan mereset hitungan untuk setiap layanan setiap hari.
    $count_stmt = $conn->prepare("SELECT COUNT(id) as total FROM antrian WHERE tanggal_kunjungan = ? AND id_layanan = ?");
    $count_stmt->bind_param("si", $tanggal_kunjungan, $id_layanan); // bind tanggal dan id_layanan
    $count_stmt->execute();
    $count_result = $count_stmt->get_result()->fetch_assoc();
    $next_number = $count_result['total'] + 1; // Nomor berikutnya adalah total untuk layanan itu + 1
    
    $nomor_antrian = $prefix . '-' . str_pad($next_number, 3, '0', STR_PAD_LEFT);

    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO antrian (id_user, id_layanan, id_dokter, tanggal_kunjungan, jam_kunjungan, nomor_antrian) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $id_user, $id_layanan, $id_dokter, $tanggal_kunjungan, $jam_kunjungan, $nomor_antrian);

    if ($stmt->execute()) {
        json_response(['message' => 'Nomor antrian berhasil dibuat.', 'queueNumber' => $nomor_antrian]);
    } else {
        if ($conn->errno == 1062) {
             json_response(['message' => 'Terjadi duplikasi nomor antrian, silakan coba lagi.'], 409);
        } else {
             json_response(['message' => 'Gagal membuat antrian: ' . $conn->error], 500);
        }
    }
}
?>