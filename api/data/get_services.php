<?php
// File: api/data/get_services.php
require_once '../../config/database.php';

$result = $conn->query("SELECT id, nama_layanan FROM layanan ORDER BY nama_layanan ASC");
$services = [];
while ($row = $result->fetch_assoc()) {
    $services[] = $row;
}

json_response($services);
$conn->close();
?>