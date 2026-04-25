<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) { echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid']); exit; }

$cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM artikel WHERE id_kategori = ?");
$cek->bind_param('i', $id);
$cek->execute();
if ($cek->get_result()->fetch_assoc()['jml'] > 0) {
    echo json_encode(['sukses' => false, 'pesan' => 'Kategori masih memiliki artikel, tidak dapat dihapus']);
    exit;
}

$stmt = $koneksi->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);
echo $stmt->execute() ? json_encode(['sukses' => true, 'pesan' => 'Kategori berhasil dihapus']) : json_encode(['sukses' => false, 'pesan' => 'Gagal menghapus']);