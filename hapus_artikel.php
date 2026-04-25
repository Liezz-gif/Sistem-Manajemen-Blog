<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) { echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid']); exit; }

$stmtG = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtG->bind_param('i', $id);
$stmtG->execute();
$row = $stmtG->get_result()->fetch_assoc();

$stmt = $koneksi->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    if ($row && $row['gambar'] && file_exists('uploads_artikel/' . $row['gambar'])) {
        unlink('uploads_artikel/' . $row['gambar']);
    }
    echo json_encode(['sukses' => true, 'pesan' => 'Artikel berhasil dihapus']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menghapus artikel']);
}