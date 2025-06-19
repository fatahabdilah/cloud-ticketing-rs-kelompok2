<?php
// File: config/database.php
// Konfigurasi tunggal untuk lingkungan Lokal dan Hostinger.

// Aktifkan session di setiap halaman
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * =================================================================
 * PENGATURAN KONEKSI DATABASE
 * =================================================================
 * Aktifkan HANYA SATU blok konfigurasi di bawah ini.
 * - Gunakan blok "LOCALHOST" saat development di komputer Anda.
 * - Gunakan blok "HOSTINGER" saat mengunggah ke server.
 * Caranya: hapus atau tambahkan komentar (/* ... * /) pada blok yang tidak digunakan.
 */


// ====== BLOK 1: PENGATURAN UNTUK LOCALHOST (Development) ======
// Aktifkan blok ini saat bekerja di komputer lokal.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cipta_hospital_db');


// ====== BLOK 2: PENGATURAN UNTUK HOSTINGER (Production) ======
// Aktifkan blok ini saat mengunggah ke Hostinger.
// define('DB_HOST', 'localhost'); // Untuk Hostinger, ini biasanya tetap 'localhost'
// define('DB_NAME', 'u919812937_cipta_hospital');
// define('DB_USER', 'u919812937_root');
// define('DB_PASS', 'Susukambing123');


// Buat koneksi ke database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error . ". Pastikan konfigurasi di database.php sudah benar untuk lingkungan Anda (Lokal/Hostinger).");
}

// Fungsi helper untuk mengirim response JSON
function json_response($data, $status_code = 200) {
    header('Content-Type: application/json');
    http_response_code($status_code);
    echo json_encode($data);
    exit();
}
?>