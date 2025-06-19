<?php
// File: api/data/get_doctors.php
require_once '../../config/database.php';

$id_layanan = $_GET['id_layanan'] ?? 0;

if ($id_layanan > 0) {
    $stmt = $conn->prepare("SELECT id, nama_dokter, spesialisasi FROM dokter WHERE id_layanan = ? ORDER BY nama_dokter ASC");
    $stmt->bind_param("i", $id_layanan);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
    json_response($doctors);
    $stmt->close();
} else {
    json_response([]);
}
$conn->close();
?>