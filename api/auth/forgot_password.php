<?php
// File: api/auth/forgot_password.php
// Kode tunggal yang bisa berjalan di mode development (lokal) dan production (Hostinger).

require_once '../../config/database.php';
// Memuat pustaka PHPMailer (pastikan direktori /vendor sudah ada)
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * =================================================================
 * PENGATURAN MODE DEVELOPMENT / PRODUCTION
 * =================================================================
 * Ganti variabel di bawah ini sesuai lingkungan:
 * - true  : untuk development di localhost (akan menampilkan link, tidak kirim email).
 * - false : untuk production di Hostinger (akan mengirim email sungguhan).
 */
$is_development_mode = true;


// Logika utama
$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['message' => 'Format email tidak valid.'], 400);
}

$stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result = $stmt_check->get_result();
if ($result->num_rows === 0) {
    json_response(['message' => 'Email tidak ditemukan di database kami.'], 404);
}

$token = bin2hex(random_bytes(50));
$token_hash = hash('sha256', $token);
$expires_at = date('Y-m-d H:i:s', time() + 3600); // Token berlaku 1 jam

$stmt_insert = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
$stmt_insert->bind_param("sss", $email, $token_hash, $expires_at);
$stmt_insert->execute();

$domain = $is_development_mode ? "http://localhost/cloud-ticketing-rs-kelompok2" : "https://domain-anda.com"; // Ganti domain-anda.com
$reset_link = $domain . "/reset_password.php?token=" . $token;

// Logika percabangan berdasarkan mode
if ($is_development_mode) {
    // --- MODE DEVELOPMENT (LOKAL) ---
    json_response([
        'message' => 'MODE SIMULASI: Link reset password berhasil dibuat.',
        'reset_link' => $reset_link
    ]);
} else {
    // --- MODE PRODUCTION (HOSTINGER) ---
    $mail = new PHPMailer(true);
    try {
        // Pengaturan Server SMTP (ganti dengan kredensial email dari Hostinger)
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com'; // SMTP Host Hostinger
        $mail->SMTPAuth   = true;
        $mail->Username   = 'no-reply@domain-anda.com';   // Email yang dibuat di Hostinger
        $mail->Password   = 'password-email-anda';      // Password email tersebut
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Pengirim dan Penerima
        $mail->setFrom('no-reply@domain-anda.com', 'Cipta Hospital Indonesia');
        $mail->addAddress($email);

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = 'Permintaan Reset Password - Cipta Hospital Indonesia';
        $mail->Body    = "Halo,<br><br>Kami menerima permintaan untuk mereset password akun Anda. " .
                         "Silakan klik tautan di bawah ini untuk membuat password baru:<br>" .
                         "<a href='{$reset_link}' style='color:#054FA9;font-weight:bold;'>Reset Password Saya</a><br><br>" .
                         "Jika Anda tidak meminta reset password, mohon abaikan email ini.<br>" .
                         "Tautan ini hanya berlaku selama 1 jam.<br><br>" .
                         "Hormat kami,<br>Cipta Hospital Indonesia";
        $mail->AltBody = "Untuk mereset password Anda, silakan salin dan tempel tautan ini di browser Anda: {$reset_link}";

        $mail->send();
        json_response(['message' => 'Berhasil! Kami telah mengirimkan link reset password ke email Anda.']);
    } catch (Exception $e) {
        // Catat error untuk debugging, tapi jangan tampilkan detail ke user
        error_log("PHPMailer Error: " . $mail->ErrorInfo);
        json_response(['message' => "Kami mengalami kendala saat mengirim email. Silakan coba lagi nanti."], 500);
    }
}
?>