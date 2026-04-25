<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid']);
    exit;
}

// Cek apakah penulis memiliki artikel
$cek = $koneksi->prepare("SELECT COUNT(*) AS jml FROM artikel WHERE id_penulis = ?");
$cek->bind_param('i', $id);
$cek->execute();
$jml = $cek->get_result()->fetch_assoc()['jml'];

if ($jml > 0) {
    echo json_encode(['sukses' => false, 'pesan' => 'Penulis masih memiliki artikel, tidak dapat dihapus']);
    exit;
}

// Ambil foto untuk dihapus
$stmtFoto = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtFoto->bind_param('i', $id);
$stmtFoto->execute();
$row = $stmtFoto->get_result()->fetch_assoc();

$stmt = $koneksi->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    if ($row && $row['foto'] !== 'default.png' && file_exists('uploads_penulis/' . $row['foto'])) {
        unlink('uploads_penulis/' . $row['foto']);
    }
    echo json_encode(['sukses' => true, 'pesan' => 'Penulis berhasil dihapus']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menghapus data']);
}