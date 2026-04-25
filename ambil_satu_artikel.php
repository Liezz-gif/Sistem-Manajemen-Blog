<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
$stmt = $koneksi->prepare("SELECT id, judul, id_penulis, id_kategori, isi, gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
echo $row ? json_encode(['sukses' => true, 'data' => $row]) : json_encode(['sukses' => false, 'pesan' => 'Tidak ditemukan']);