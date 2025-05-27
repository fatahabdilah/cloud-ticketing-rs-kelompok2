<?php

header('Content-Type: application/json');

// Cek apakah request method adalah GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    echo json_encode([
        'message' => 'Hello, World'
        
    ]);
} else {
    // Jika bukan GET, kembalikan error
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'error' => 'Only GET method is allowed'
    ]);
}
?>
