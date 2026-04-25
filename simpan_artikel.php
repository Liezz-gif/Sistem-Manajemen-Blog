<?php
require 'koneksi.php';
header('Content-Type: application/json');

$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = intval($_POST['id_penulis'] ?? 0);
$id_kategori = intval($_POST['id_kategori'] ?? 0);
$isi         = trim($_POST['isi'] ?? '');

if (!$judul || !$id_penulis || !$id_kategori || !$isi) {
    echo json_encode(['sukses' => false, 'pesan' => 'Semua field wajib diisi']);
    exit;
}

// Upload gambar wajib
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['sukses' => false, 'pesan' => 'Gambar artikel wajib diunggah']);
    exit;
}

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

// Generate hari_tanggal
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
           7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
$now    = new DateTime();
$hari_tanggal = $hari[$now->format('w')] . ', ' . $now->format('j') . ' ' .
                $bulan[(int)$now->format('n')] . ' ' . $now->format('Y') . ' | ' . $now->format('H:i');

$stmt = $koneksi->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?,?,?,?,?,?)");
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $nama, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Artikel berhasil ditambahkan']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menyimpan artikel']);
}