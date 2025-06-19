<?php
// File: api/auth/logout.php
require_once '../../config/database.php';

session_unset();
session_destroy();

json_response(['message' => 'Logout berhasil.']);
?>