<?php
// File: api/user/get_tickets.php
// Versi ini disempurnakan dengan urutan tiket yang lebih logis.

require_once '../../config/database.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    json_response(['message' => 'Unauthorized: Anda harus login terlebih dahulu.'], 401);
}

$id_user = $_SESSION['user_id'];
$current_datetime = date('Y-m-d H:i:s');

// BAGIAN 1: UPDATE STATUS TIKET OTOMATIS MENJADI 'KADALUARSA'
// Logika ini tetap sama, memastikan status tiket selalu akurat sebelum ditampilkan.
$update_query = "
    UPDATE antrian
    SET status = 'Kadaluarsa'
    WHERE id_user = ?
    AND status = 'Menunggu'
    AND CONCAT(tanggal_kunjungan, ' ', jam_kunjungan) COLLATE utf8mb4_unicode_ci < ?
";

$update_stmt = $conn->prepare($update_query);
if ($update_stmt === false) {
    json_response(['message' => 'Gagal mempersiapkan query update: ' . $conn->error], 500);
}
$update_stmt->bind_param("is", $id_user, $current_datetime);
$update_stmt->execute();
$update_stmt->close();


// BAGIAN 2: AMBIL SEMUA TIKET DENGAN URUTAN YANG LEBIH BAIK
$stmt = $conn->prepare("
    SELECT
        a.nomor_antrian, a.tanggal_kunjungan, a.jam_kunjungan, a.status,
        l.nama_layanan, d.nama_dokter, d.spesialisasi
    FROM
        antrian a
    LEFT JOIN
        layanan l ON a.id_layanan = l.id
    LEFT JOIN
        dokter d ON a.id_dokter = d.id
    WHERE
        a.id_user = ?
    /* * =================================================================
     * PEMBARUAN UTAMA: KLAUSA ORDER BY YANG LEBIH CERDAS
     * =================================================================
     * Mengurutkan berdasarkan prioritas status, lalu berdasarkan tanggal.
    */
    ORDER BY
        -- Langkah 1: Urutkan berdasarkan prioritas status
        CASE
            WHEN a.status = 'Menunggu'   THEN 1 -- Paling penting
            WHEN a.status = 'Kadaluarsa' THEN 2 -- Penting kedua
            WHEN a.status = 'Selesai'    THEN 3 -- Riwayat
            WHEN a.status = 'Batal'      THEN 4 -- Riwayat
            ELSE 99                        -- Status lain (jika ada)
        END ASC,

        -- Langkah 2: Untuk tiket 'Menunggu', urutkan dari yang paling dekat
        CASE
            WHEN a.status = 'Menunggu' THEN a.tanggal_kunjungan
        END ASC,
        CASE
            WHEN a.status = 'Menunggu' THEN a.jam_kunjungan
        END ASC,

        -- Langkah 3: Untuk semua tiket lainnya (riwayat), urutkan dari yang paling baru
        CASE
            WHEN a.status <> 'Menunggu' THEN a.tanggal_kunjungan
        END DESC,
        CASE
            WHEN a.status <> 'Menunggu' THEN a.jam_kunjungan
        END DESC
");

if ($stmt === false) {
    json_response(['message' => 'Gagal mempersiapkan query select: ' . $conn->error], 500);
}

$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$tickets = [];
while ($row = $result->fetch_assoc()) {
    if (!empty($row['jam_kunjungan'])) {
        $row['jam_kunjungan'] = date('H:i', strtotime($row['jam_kunjungan']));
    }
    $tickets[] = $row;
}

json_response($tickets);

$stmt->close();
$conn->close();
?>