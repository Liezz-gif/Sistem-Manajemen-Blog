<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'db_blog';

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    http_response_code(500);
    echo json_encode(['sukses' => false, 'pesan' => 'Koneksi database gagal: ' . $koneksi->connect_error]);
    exit;
}

$koneksi->set_charset('utf8mb4');