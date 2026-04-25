<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Manajemen Blog (CMS)</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --primary:   #0d6efd;
    --primary-dark: #0b5ed7;
    --danger:    #dc3545;
    --danger-dark: #bb2d3b;
    --success:   #198754;
    --bg:        #f0f2f5;
    --sidebar-bg:#1e293b;
    --sidebar-active:#0d6efd;
    --white:     #ffffff;
    --border:    #dee2e6;
    --text:      #212529;
    --text-muted:#6c757d;
    --shadow:    0 1px 4px rgba(0,0,0,.12);
    --radius:    8px;
  }

  body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

  /* ── HEADER ── */
  header {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
    height: 56px;
    display: flex;
    align-items: center;
    gap: 12px;
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    box-shadow: var(--shadow);
  }
  header .logo-icon {
    width: 32px; height: 32px;
    background: var(--primary);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 16px;
  }
  header .app-name { font-weight: 700; font-size: 15px; color: var(--text); }
  header .app-sub  { font-size: 12px; color: var(--text-muted); }

  /* ── LAYOUT ── */
  .wrapper { display: flex; padding-top: 56px; min-height: 100vh; }

  /* ── SIDEBAR ── */
  aside {
    width: 220px; flex-shrink: 0;
    background: var(--sidebar-bg);
    min-height: calc(100vh - 56px);
    position: fixed; top: 56px; left: 0; bottom: 0;
    padding: 16px 0;
    overflow-y: auto;
  }
  .nav-label {
    font-size: 10px; font-weight: 600; letter-spacing: .08em;
    color: #94a3b8; padding: 0 16px 8px; text-transform: uppercase;
  }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 16px;
    color: #cbd5e1; font-size: 13.5px; font-weight: 500;
    cursor: pointer; transition: background .15s, color .15s;
    border-left: 3px solid transparent;
  }
  .nav-item:hover { background: rgba(255,255,255,.06); color: #fff; }
  .nav-item.active { background: rgba(13,110,253,.2); color: #fff; border-left-color: var(--primary); }
  .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; }

  /* ── MAIN CONTENT ── */
  main { margin-left: 220px; padding: 24px; flex: 1; }

  /* ── SECTION CARD ── */
  .section { display: none; }
  .section.active { display: block; }

  .card {
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
  }
  .card-header h5 { font-size: 15px; font-weight: 600; }

  /* ── BUTTONS ── */
  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 6px;
    font-size: 13px; font-weight: 500; cursor: pointer;
    border: none; transition: background .15s, opacity .15s;
  }
  .btn-primary { background: var(--primary); color: #fff; }
  .btn-primary:hover { background: var(--primary-dark); }
  .btn-danger  { background: var(--danger); color: #fff; }
  .btn-danger:hover { background: var(--danger-dark); }
  .btn-secondary { background: #6c757d; color: #fff; }
  .btn-secondary:hover { background: #5c636a; }
  .btn-sm { padding: 4px 10px; font-size: 12px; border-radius: 5px; }
  .btn-success { background: var(--success); color: #fff; }

  /* ── TABLE ── */
  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #f8f9fa; }
  th { padding: 11px 16px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .04em; border-bottom: 1px solid var(--border); }
  td { padding: 12px 16px; font-size: 13.5px; border-bottom: 1px solid #f1f3f5; vertical-align: middle; }
  tr:last-child td { border-bottom: none; }
  tr:hover td { background: #fafbfc; }

  .foto-thumb {
    width: 40px; height: 40px; border-radius: 6px;
    object-fit: cover; background: #e9ecef;
    display: block;
  }
  .gambar-thumb {
    width: 48px; height: 36px; border-radius: 4px;
    object-fit: cover; background: #e9ecef;
    display: block;
  }

  /* Badge kategori */
  .badge {
    display: inline-block; padding: 3px 10px;
    border-radius: 20px; font-size: 11.5px; font-weight: 600;
  }
  .badge-tutorial  { background: #cfe2ff; color: #0a58ca; }
  .badge-database  { background: #d1e7dd; color: #0f5132; }
  .badge-design    { background: #fce8b2; color: #856404; }
  .badge-default   { background: #e2e3e5; color: #41464b; }

  /* Password mask */
  .pw-mask { letter-spacing: 2px; color: var(--text-muted); }

  /* ── MODAL ── */
  .overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.45); z-index: 200;
    align-items: center; justify-content: center;
  }
  .overlay.show { display: flex; }
  .modal {
    background: var(--white); border-radius: var(--radius);
    width: 480px; max-width: 95vw; max-height: 90vh;
    overflow-y: auto; padding: 28px;
    box-shadow: 0 8px 32px rgba(0,0,0,.2);
    animation: modalIn .2s ease;
  }
  @keyframes modalIn { from { transform: translateY(-16px); opacity: 0; } to { transform: none; opacity: 1; } }

  .modal h4 { font-size: 16px; font-weight: 700; margin-bottom: 20px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-group { margin-bottom: 14px; }
  .form-group label { display: block; font-size: 12.5px; font-weight: 500; margin-bottom: 5px; color: #495057; }
  .form-control {
    width: 100%; padding: 8px 11px;
    border: 1px solid var(--border); border-radius: 6px;
    font-size: 13.5px; font-family: inherit;
    transition: border-color .15s, box-shadow .15s;
    color: var(--text); background: #fff;
  }
  .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,110,253,.15); }
  textarea.form-control { resize: vertical; min-height: 90px; }
  select.form-control { cursor: pointer; }

  .form-hint { font-size: 11.5px; color: var(--text-muted); margin-top: 3px; }

  .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }

  /* ── CONFIRM MODAL ── */
  .confirm-modal {
    width: 340px; text-align: center; padding: 32px 28px;
  }
  .confirm-icon { font-size: 36px; color: var(--danger); margin-bottom: 12px; }
  .confirm-modal h4 { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
  .confirm-modal p { font-size: 13px; color: var(--text-muted); margin-bottom: 22px; }
  .confirm-actions { display: flex; justify-content: center; gap: 12px; }

  /* ── TOAST ── */
  #toast {
    position: fixed; bottom: 24px; right: 24px; z-index: 9999;
    background: #1e293b; color: #fff;
    padding: 12px 20px; border-radius: 8px;
    font-size: 13.5px; font-weight: 500;
    box-shadow: 0 4px 16px rgba(0,0,0,.25);
    opacity: 0; transform: translateY(12px);
    transition: opacity .25s, transform .25s;
    pointer-events: none;
  }
  #toast.show { opacity: 1; transform: none; }
  #toast.success { border-left: 4px solid #22c55e; }
  #toast.error   { border-left: 4px solid var(--danger); }

  /* Loading spinner */
  .loading-row td { text-align: center; padding: 32px; color: var(--text-muted); font-size: 13px; }

  /* Empty state */
  .empty-row td { text-align: center; padding: 40px; color: var(--text-muted); font-size: 13px; }
</style>
</head>
<body>

<!-- HEADER -->
<header>
  <div class="logo-icon">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" width="18" height="18">
      <rect x="3" y="3" width="18" height="18" rx="3"/><path d="M7 8h10M7 12h6M7 16h8"/>
    </svg>
  </div>
  <div>
    <div class="app-name">Sistem Manajemen Blog (CMS)</div>
    <div class="app-sub">Blog Keren</div>
  </div>
</header>

<div class="wrapper">
  <!-- SIDEBAR -->
  <aside>
    <div class="nav-label">Menu Utama</div>
    <div class="nav-item active" data-section="penulis">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
      Kelola Penulis
    </div>
    <div class="nav-item" data-section="artikel">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Kelola Artikel
    </div>
    <div class="nav-item" data-section="kategori">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Kelola Kategori
    </div>
  </aside>

  <!-- MAIN -->
  <main>

    <!-- ═══════════════ PENULIS ═══════════════ -->
    <div class="section active" id="section-penulis">
      <div class="card">
        <div class="card-header">
          <h5>Data Penulis</h5>
          <button class="btn btn-primary" onclick="bukaModalTambahPenulis()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Penulis
          </button>
        </div>
        <div style="overflow-x:auto">
          <table id="tbl-penulis">
            <thead><tr><th>Foto</th><th>Nama</th><th>Username</th><th>Password</th><th>Aksi</th></tr></thead>
            <tbody id="tbody-penulis"><tr class="loading-row"><td colspan="5">Memuat data…</td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══════════════ ARTIKEL ═══════════════ -->
    <div class="section" id="section-artikel">
      <div class="card">
        <div class="card-header">
          <h5>Data Artikel</h5>
          <button class="btn btn-primary" onclick="bukaModalTambahArtikel()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Artikel
          </button>
        </div>
        <div style="overflow-x:auto">
          <table id="tbl-artikel">
            <thead><tr><th>Gambar</th><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody id="tbody-artikel"><tr class="loading-row"><td colspan="6">Memuat data…</td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ═══════════════ KATEGORI ═══════════════ -->
    <div class="section" id="section-kategori">
      <div class="card">
        <div class="card-header">
          <h5>Data Kategori Artikel</h5>
          <button class="btn btn-primary" onclick="bukaModalTambahKategori()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="14" height="14"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Kategori
          </button>
        </div>
        <div style="overflow-x:auto">
          <table id="tbl-kategori">
            <thead><tr><th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th></tr></thead>
            <tbody id="tbody-kategori"><tr class="loading-row"><td colspan="3">Memuat data…</td></tr></tbody>
          </table>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- ══════════════════════════════════════════
     MODAL: TAMBAH PENULIS
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-tambah-penulis">
  <div class="modal">
    <h4>Tambah Penulis</h4>
    <form id="form-tambah-penulis" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group">
          <label>Nama Depan</label>
          <input type="text" name="nama_depan" class="form-control" placeholder="Ahmad" required>
        </div>
        <div class="form-group">
          <label>Nama Belakang</label>
          <input type="text" name="nama_belakang" class="form-control" placeholder="Fauzi" required>
        </div>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="user_name" class="form-control" placeholder="ahmad_f" required>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Foto Profil</label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        <div class="form-hint">Opsional. Maks. 2 MB. Format: JPG, PNG, GIF, WEBP</div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupOverlay('overlay-tambah-penulis')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: EDIT PENULIS
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-edit-penulis">
  <div class="modal">
    <h4>Edit Penulis</h4>
    <form id="form-edit-penulis" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-penulis-id">
      <div class="form-row">
        <div class="form-group">
          <label>Nama Depan</label>
          <input type="text" name="nama_depan" id="edit-penulis-nama-depan" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Nama Belakang</label>
          <input type="text" name="nama_belakang" id="edit-penulis-nama-belakang" class="form-control" required>
        </div>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="user_name" id="edit-penulis-username" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Password Baru <span style="color:var(--text-muted);font-weight:400">(kosongkan jika tidak diganti)</span></label>
        <input type="password" name="password" class="form-control" placeholder="••••••••••••">
      </div>
      <div class="form-group">
        <label>Foto Profil <span style="color:var(--text-muted);font-weight:400">(kosongkan jika tidak diganti)</span></label>
        <input type="file" name="foto" class="form-control" accept="image/*">
        <div class="form-hint">Maks. 2 MB. Format: JPG, PNG, GIF, WEBP</div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupOverlay('overlay-edit-penulis')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: TAMBAH ARTIKEL
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-tambah-artikel">
  <div class="modal">
    <h4>Tambah Artikel</h4>
    <form id="form-tambah-artikel" enctype="multipart/form-data">
      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" class="form-control" placeholder="Judul artikel..." required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Penulis</label>
          <select name="id_penulis" id="select-penulis-tambah" class="form-control" required>
            <option value="">Pilih penulis</option>
          </select>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select name="id_kategori" id="select-kategori-tambah" class="form-control" required>
            <option value="">Pilih kategori</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Isi Artikel</label>
        <textarea name="isi" class="form-control" placeholder="Tulis isi artikel di sini..." required style="min-height:110px"></textarea>
      </div>
      <div class="form-group">
        <label>Gambar</label>
        <input type="file" name="gambar" class="form-control" accept="image/*" required>
        <div class="form-hint">Wajib. Maks. 2 MB. Format: JPG, PNG, GIF, WEBP</div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupOverlay('overlay-tambah-artikel')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: EDIT ARTIKEL
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-edit-artikel">
  <div class="modal">
    <h4>Edit Artikel</h4>
    <form id="form-edit-artikel" enctype="multipart/form-data">
      <input type="hidden" name="id" id="edit-artikel-id">
      <div class="form-group">
        <label>Judul</label>
        <input type="text" name="judul" id="edit-artikel-judul" class="form-control" required>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Penulis</label>
          <select name="id_penulis" id="select-penulis-edit" class="form-control" required>
            <option value="">Pilih penulis</option>
          </select>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select name="id_kategori" id="select-kategori-edit" class="form-control" required>
            <option value="">Pilih kategori</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Isi Artikel</label>
        <textarea name="isi" id="edit-artikel-isi" class="form-control" required style="min-height:110px"></textarea>
      </div>
      <div class="form-group">
        <label>Gambar <span style="color:var(--text-muted);font-weight:400">(kosongkan jika tidak diganti)</span></label>
        <input type="file" name="gambar" class="form-control" accept="image/*">
        <div class="form-hint">Maks. 2 MB. Format: JPG, PNG, GIF, WEBP</div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupOverlay('overlay-edit-artikel')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: TAMBAH KATEGORI
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-tambah-kategori">
  <div class="modal" style="max-width:420px">
    <h4>Tambah Kategori</h4>
    <form id="form-tambah-kategori">
      <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama kategori..." required>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" placeholder="Deskripsi kategori..."></textarea>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupOverlay('overlay-tambah-kategori')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: EDIT KATEGORI
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-edit-kategori">
  <div class="modal" style="max-width:420px">
    <h4>Edit Kategori</h4>
    <form id="form-edit-kategori">
      <input type="hidden" name="id" id="edit-kategori-id">
      <div class="form-group">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" id="edit-kategori-nama" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan" id="edit-kategori-ket" class="form-control"></textarea>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="tutupOverlay('overlay-edit-kategori')">Batal</button>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- ══════════════════════════════════════════
     MODAL: KONFIRMASI HAPUS
═══════════════════════════════════════════ -->
<div class="overlay" id="overlay-hapus">
  <div class="modal confirm-modal">
    <div class="confirm-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="48" height="48">
        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
      </svg>
    </div>
    <h4>Hapus data ini?</h4>
    <p>Data yang dihapus tidak dapat dikembalikan.</p>
    <div class="confirm-actions">
      <button class="btn btn-secondary" onclick="tutupOverlay('overlay-hapus')">Batal</button>
      <button class="btn btn-danger" id="btn-konfirmasi-hapus">Ya, Hapus</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div id="toast"></div>

<script>
// ─────────────────────────────────────────────
//  HELPERS
// ─────────────────────────────────────────────
function esc(str) {
  const d = document.createElement('div');
  d.textContent = str ?? '';
  return d.innerHTML;
}

function tampilToast(pesan, tipe = 'success') {
  const t = document.getElementById('toast');
  t.textContent = pesan;
  t.className = 'show ' + tipe;
  clearTimeout(t._timer);
  t._timer = setTimeout(() => { t.className = ''; }, 3000);
}

function bukaOverlay(id) {
  document.getElementById(id).classList.add('show');
}
function tutupOverlay(id) {
  document.getElementById(id).classList.remove('show');
}

// Tutup overlay saat klik backdrop
document.querySelectorAll('.overlay').forEach(ov => {
  ov.addEventListener('click', e => { if (e.target === ov) tutupOverlay(ov.id); });
});

// ─────────────────────────────────────────────
//  NAVIGASI
// ─────────────────────────────────────────────
const sectionLoaded = { penulis: false, artikel: false, kategori: false };

document.querySelectorAll('.nav-item').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    item.classList.add('active');
    const sec = item.dataset.section;
    document.getElementById('section-' + sec).classList.add('active');
    if (!sectionLoaded[sec]) { loadSection(sec); sectionLoaded[sec] = true; }
  });
});

function loadSection(sec) {
  if (sec === 'penulis')  muatPenulis();
  if (sec === 'artikel')  muatArtikel();
  if (sec === 'kategori') muatKategori();
}

// ─────────────────────────────────────────────
//  BADGE KATEGORI
// ─────────────────────────────────────────────
function badgeKategori(nama) {
  const n = nama.toLowerCase();
  let cls = 'badge-default';
  if (n.includes('tutorial'))  cls = 'badge-tutorial';
  else if (n.includes('database')) cls = 'badge-database';
  else if (n.includes('design') || n.includes('desain')) cls = 'badge-design';
  return `<span class="badge ${cls}">${esc(nama)}</span>`;
}

// ─────────────────────────────────────────────
//  ══ PENULIS ══
// ─────────────────────────────────────────────
function muatPenulis() {
  const tb = document.getElementById('tbody-penulis');
  tb.innerHTML = '<tr class="loading-row"><td colspan="5">Memuat data…</td></tr>';
  fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      if (!res.sukses || !res.data.length) {
        tb.innerHTML = '<tr class="empty-row"><td colspan="5">Belum ada data penulis.</td></tr>';
        return;
      }
      tb.innerHTML = res.data.map(p => `
        <tr>
          <td><img src="uploads_penulis/${esc(p.foto)}" class="foto-thumb" onerror="this.src='uploads_penulis/default.png'" alt="foto"></td>
          <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
          <td>${esc(p.user_name)}</td>
          <td><span class="pw-mask">••••••••••••</span></td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="bukaEditPenulis(${p.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('penulis', ${p.id})">Hapus</button>
          </td>
        </tr>`).join('');
    })
    .catch(() => { tb.innerHTML = '<tr class="empty-row"><td colspan="5">Gagal memuat data.</td></tr>'; });
}

function bukaModalTambahPenulis() {
  document.getElementById('form-tambah-penulis').reset();
  bukaOverlay('overlay-tambah-penulis');
}

document.getElementById('form-tambah-penulis').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('simpan_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.sukses) {
        tutupOverlay('overlay-tambah-penulis');
        tampilToast(res.pesan, 'success');
        muatPenulis();
      } else {
        tampilToast(res.pesan, 'error');
      }
    });
});

function bukaEditPenulis(id) {
  fetch('ambil_satu_penulis.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (!res.sukses) { tampilToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('edit-penulis-id').value = d.id;
      document.getElementById('edit-penulis-nama-depan').value = d.nama_depan;
      document.getElementById('edit-penulis-nama-belakang').value = d.nama_belakang;
      document.getElementById('edit-penulis-username').value = d.user_name;
      document.querySelector('#form-edit-penulis [name="password"]').value = '';
      document.querySelector('#form-edit-penulis [name="foto"]').value = '';
      bukaOverlay('overlay-edit-penulis');
    });
}

document.getElementById('form-edit-penulis').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('update_penulis.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.sukses) {
        tutupOverlay('overlay-edit-penulis');
        tampilToast(res.pesan, 'success');
        muatPenulis();
      } else {
        tampilToast(res.pesan, 'error');
      }
    });
});

// ─────────────────────────────────────────────
//  ══ ARTIKEL ══
// ─────────────────────────────────────────────
function muatArtikel() {
  const tb = document.getElementById('tbody-artikel');
  tb.innerHTML = '<tr class="loading-row"><td colspan="6">Memuat data…</td></tr>';
  fetch('ambil_artikel.php')
    .then(r => r.json())
    .then(res => {
      if (!res.sukses || !res.data.length) {
        tb.innerHTML = '<tr class="empty-row"><td colspan="6">Belum ada data artikel.</td></tr>';
        return;
      }
      tb.innerHTML = res.data.map(a => `
        <tr>
          <td><img src="uploads_artikel/${esc(a.gambar)}" class="gambar-thumb" onerror="this.style.background='#e9ecef'" alt="gambar"></td>
          <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${esc(a.judul)}</td>
          <td>${badgeKategori(a.nama_kategori)}</td>
          <td>${esc(a.nama_depan)} ${esc(a.nama_belakang)}</td>
          <td style="white-space:nowrap;font-size:12.5px;color:var(--text-muted)">${esc(a.hari_tanggal)}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="bukaEditArtikel(${a.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('artikel', ${a.id})">Hapus</button>
          </td>
        </tr>`).join('');
    })
    .catch(() => { tb.innerHTML = '<tr class="empty-row"><td colspan="6">Gagal memuat data.</td></tr>'; });
}

function isiDropdownPenulis(selectId, selectedId = null) {
  return fetch('ambil_penulis.php')
    .then(r => r.json())
    .then(res => {
      const sel = document.getElementById(selectId);
      sel.innerHTML = '<option value="">Pilih penulis</option>';
      if (res.sukses) res.data.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id;
        opt.textContent = p.nama_depan + ' ' + p.nama_belakang;
        if (selectedId && p.id == selectedId) opt.selected = true;
        sel.appendChild(opt);
      });
    });
}

function isiDropdownKategori(selectId, selectedId = null) {
  return fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      const sel = document.getElementById(selectId);
      sel.innerHTML = '<option value="">Pilih kategori</option>';
      if (res.sukses) res.data.forEach(k => {
        const opt = document.createElement('option');
        opt.value = k.id;
        opt.textContent = k.nama_kategori;
        if (selectedId && k.id == selectedId) opt.selected = true;
        sel.appendChild(opt);
      });
    });
}

function bukaModalTambahArtikel() {
  document.getElementById('form-tambah-artikel').reset();
  Promise.all([
    isiDropdownPenulis('select-penulis-tambah'),
    isiDropdownKategori('select-kategori-tambah')
  ]).then(() => bukaOverlay('overlay-tambah-artikel'));
}

document.getElementById('form-tambah-artikel').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('simpan_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.sukses) {
        tutupOverlay('overlay-tambah-artikel');
        tampilToast(res.pesan, 'success');
        muatArtikel();
      } else {
        tampilToast(res.pesan, 'error');
      }
    });
});

function bukaEditArtikel(id) {
  fetch('ambil_satu_artikel.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (!res.sukses) { tampilToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('edit-artikel-id').value = d.id;
      document.getElementById('edit-artikel-judul').value = d.judul;
      document.getElementById('edit-artikel-isi').value = d.isi;
      document.querySelector('#form-edit-artikel [name="gambar"]').value = '';
      Promise.all([
        isiDropdownPenulis('select-penulis-edit', d.id_penulis),
        isiDropdownKategori('select-kategori-edit', d.id_kategori)
      ]).then(() => bukaOverlay('overlay-edit-artikel'));
    });
}

document.getElementById('form-edit-artikel').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('update_artikel.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.sukses) {
        tutupOverlay('overlay-edit-artikel');
        tampilToast(res.pesan, 'success');
        muatArtikel();
      } else {
        tampilToast(res.pesan, 'error');
      }
    });
});

// ─────────────────────────────────────────────
//  ══ KATEGORI ══
// ─────────────────────────────────────────────
function muatKategori() {
  const tb = document.getElementById('tbody-kategori');
  tb.innerHTML = '<tr class="loading-row"><td colspan="3">Memuat data…</td></tr>';
  fetch('ambil_kategori.php')
    .then(r => r.json())
    .then(res => {
      if (!res.sukses || !res.data.length) {
        tb.innerHTML = '<tr class="empty-row"><td colspan="3">Belum ada data kategori.</td></tr>';
        return;
      }
      tb.innerHTML = res.data.map(k => `
        <tr>
          <td>${badgeKategori(k.nama_kategori)}</td>
          <td style="color:var(--text-muted);font-size:13px">${esc(k.keterangan)}</td>
          <td>
            <button class="btn btn-primary btn-sm" onclick="bukaEditKategori(${k.id})">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="konfirmasiHapus('kategori', ${k.id})">Hapus</button>
          </td>
        </tr>`).join('');
    })
    .catch(() => { tb.innerHTML = '<tr class="empty-row"><td colspan="3">Gagal memuat data.</td></tr>'; });
}

function bukaModalTambahKategori() {
  document.getElementById('form-tambah-kategori').reset();
  bukaOverlay('overlay-tambah-kategori');
}

document.getElementById('form-tambah-kategori').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('simpan_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.sukses) {
        tutupOverlay('overlay-tambah-kategori');
        tampilToast(res.pesan, 'success');
        muatKategori();
      } else {
        tampilToast(res.pesan, 'error');
      }
    });
});

function bukaEditKategori(id) {
  fetch('ambil_satu_kategori.php?id=' + id)
    .then(r => r.json())
    .then(res => {
      if (!res.sukses) { tampilToast(res.pesan, 'error'); return; }
      const d = res.data;
      document.getElementById('edit-kategori-id').value = d.id;
      document.getElementById('edit-kategori-nama').value = d.nama_kategori;
      document.getElementById('edit-kategori-ket').value = d.keterangan ?? '';
      bukaOverlay('overlay-edit-kategori');
    });
}

document.getElementById('form-edit-kategori').addEventListener('submit', function(e) {
  e.preventDefault();
  const fd = new FormData(this);
  fetch('update_kategori.php', { method: 'POST', body: fd })
    .then(r => r.json())
    .then(res => {
      if (res.sukses) {
        tutupOverlay('overlay-edit-kategori');
        tampilToast(res.pesan, 'success');
        muatKategori();
      } else {
        tampilToast(res.pesan, 'error');
      }
    });
});

// ─────────────────────────────────────────────
//  KONFIRMASI HAPUS (universal)
// ─────────────────────────────────────────────
function konfirmasiHapus(tipe, id) {
  bukaOverlay('overlay-hapus');
  const btn = document.getElementById('btn-konfirmasi-hapus');
  // Clone untuk hapus event lama
  const newBtn = btn.cloneNode(true);
  btn.parentNode.replaceChild(newBtn, btn);

  const urlMap = { penulis: 'hapus_penulis.php', artikel: 'hapus_artikel.php', kategori: 'hapus_kategori.php' };
  const muatMap = { penulis: muatPenulis, artikel: muatArtikel, kategori: muatKategori };

  newBtn.addEventListener('click', () => {
    const fd = new FormData();
    fd.append('id', id);
    fetch(urlMap[tipe], { method: 'POST', body: fd })
      .then(r => r.json())
      .then(res => {
        tutupOverlay('overlay-hapus');
        if (res.sukses) {
          tampilToast(res.pesan, 'success');
          muatMap[tipe]();
        } else {
          tampilToast(res.pesan, 'error');
        }
      });
  });
}

// ─────────────────────────────────────────────
//  INIT — muat data penulis langsung
// ─────────────────────────────────────────────
muatPenulis();
sectionLoaded.penulis = true;
</script>
</body>
</html>
