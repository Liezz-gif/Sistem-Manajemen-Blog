<?php
require 'koneksi.php';
header('Content-Type: application/json');

$id          = intval($_POST['id'] ?? 0);
$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if ($id <= 0 || !$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak lengkap']);
    exit;
}

// Ambil gambar lama
$stmtOld = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old   = $stmtOld->get_result()->fetch_assoc();
$gambar = $old['gambar'] ?? '';

// Handle gambar baru (opsional)
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['gambar']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mime, $allowed)) {
        echo json_encode(['sukses' => false, 'pesan' => 'Tipe file tidak diizinkan']);
        exit;
    }
    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['sukses' => false, 'pesan' => 'Ukuran file maksimal 2 MB']);
        exit;
    }
    $ext   = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $nama  = uniqid('artikel_', true) . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $nama);
    if ($gambar && file_exists('uploads_artikel/' . $gambar)) {
        unlink('uploads_artikel/' . $gambar);
    }
    $gambar = $nama;
}

$stmt = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

echo $stmt->execute() ? json_encode(['sukses' => true, 'pesan' => 'Artikel berhasil diperbarui'])
                      : json_encode(['sukses' => false, 'pesan' => 'Gagal memperbarui artikel']);