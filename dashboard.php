<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$user_nama = $_SESSION['user_nama'];
$user_role = $_SESSION['user_role'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Data Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #2563EB;
            --secondary: #7C3AED;
            --green: #10B981;
            --red: #DC2626;
            --bg: #0F172A;
            --card: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.08);
            --text: #F1F5F9;
            --muted: #94A3B8;
        }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(145deg, #0F172A 0%, #1E293B 100%);
            color: var(--text);
            padding: 20px;
        }

        /* NAVBAR */
        .navbar {
            max-width: 1280px;
            margin: 0 auto 20px;
            background: var(--card);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 16px 28px;
            border: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }
        .navbar-brand {
            display: flex; align-items: center; gap: 12px;
        }
        .navbar-brand i {
            font-size: 24px;
            background: linear-gradient(135deg, #60A5FA, #A78BFA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .navbar-brand h1 {
            font-size: 20px; font-weight: 800;
            background: linear-gradient(135deg, #60A5FA, #A78BFA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .navbar-menu {
            display: flex; gap: 8px; flex-wrap: wrap;
        }
        .nav-link {
            padding: 8px 18px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.3s ease;
            background: transparent;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .nav-link:hover { color: var(--text); background: rgba(37, 99, 235, 0.06); }
        .nav-link.active {
            color: #60A5FA;
            background: rgba(37, 99, 235, 0.10);
            border-color: rgba(37, 99, 235, 0.15);
        }
        .user-info {
            display: flex; align-items: center; gap: 12px;
            padding: 6px 16px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 40px;
            font-size: 13px;
            color: var(--muted);
        }
        .user-info strong { color: #60A5FA; }
        .btn-logout {
            padding: 8px 18px;
            border-radius: 40px;
            background: rgba(220, 38, 38, 0.15);
            color: #F87171;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-logout:hover { background: rgba(220, 38, 38, 0.25); }

        /* CONTAINER */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px 36px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        /* PAGE */
        .page { display: none; animation: fade 0.4s ease; }
        .page.active { display: block; }
        @keyframes fade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #FFF;
        }
        .page-title i { color: #60A5FA; }

        /* SEARCH */
        .search-wrap {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 20px;
            background: var(--card);
            padding: 4px 4px 4px 20px;
            border-radius: 60px;
            border: 1px solid var(--border);
            max-width: 500px;
        }
        .search-wrap i { color: var(--muted); }
        .search-wrap input {
            flex: 1; padding: 10px;
            background: transparent; border: none;
            color: var(--text); font-size: 14px; outline: none;
        }
        .search-wrap input::placeholder { color: var(--muted); }

        /* FORM */
        .form-card {
            background: var(--card);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
        }
        .form-row {
            display: flex; flex-wrap: wrap;
            gap: 12px; align-items: flex-end;
        }
        .form-group { flex: 1 1 150px; min-width: 130px; }
        .form-group label {
            display: block; font-size: 11px;
            font-weight: 700; text-transform: uppercase;
            color: var(--muted); margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .form-group label i { margin-right: 4px; color: #60A5FA; }
        .form-group input, .form-group select {
            width: 100%; padding: 11px 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text); font-size: 13px;
            font-family: 'Inter', sans-serif; outline: none;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }
        .form-group select option { background: #1E293B; color: #F1F5F9; }

        /* BUTTONS */
        .btn {
            padding: 11px 24px;
            border: none; border-radius: 40px;
            font-weight: 700; font-size: 13px;
            cursor: pointer; transition: all 0.3s ease;
            display: inline-flex; align-items: center; gap: 8px;
            font-family: 'Inter', sans-serif;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary {
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            color: white;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
        }
        .btn-save {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }
        .btn-edit {
            background: rgba(37, 99, 235, 0.15);
            color: #60A5FA; padding: 6px 14px;
            font-size: 12px; border-radius: 30px;
        }
        .btn-delete {
            background: rgba(220, 38, 38, 0.15);
            color: #F87171; padding: 6px 14px;
            font-size: 12px; border-radius: 30px;
        }

        /* TABLE */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            background: var(--card);
            border: 1px solid var(--border);
            position: relative;
        }
        table {
            width: 100%; border-collapse: collapse;
            min-width: 900px; font-size: 13px;
        }
        thead { background: rgba(37, 99, 235, 0.1); }
        th {
            text-align: left; padding: 14px 16px;
            font-weight: 700; font-size: 11px;
            text-transform: uppercase; color: #93C5FD;
            border-bottom: 1px solid var(--border);
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }
        tbody tr:nth-child(even) { background: rgba(255, 255, 255, 0.02); }
        tbody tr:hover { background: rgba(37, 99, 235, 0.08); }

        .badge-gender {
            display: inline-block; padding: 3px 12px;
            border-radius: 30px; font-size: 11px; font-weight: 700;
        }
        .badge-male { background: rgba(37, 99, 235, 0.15); color: #60A5FA; }
        .badge-female { background: rgba(236, 72, 153, 0.15); color: #F472B6; }

        .aksi-cell { display: flex; gap: 8px; }

        /* PAGINATION */
        .pagination-wrapper {
            display: flex; justify-content: space-between;
            align-items: center; flex-wrap: wrap;
            gap: 16px; margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .pagination-info { color: var(--muted); font-size: 13px; }
        .pagination-info strong { color: #60A5FA; font-weight: 700; }
        .pagination-controls { display: flex; gap: 6px; flex-wrap: wrap; }
        .page-btn {
            min-width: 38px; height: 38px; padding: 0 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.03);
            color: var(--text); font-size: 13px;
            font-weight: 600; cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .page-btn:hover:not(:disabled) {
            background: rgba(37, 99, 235, 0.15);
            color: #60A5FA; transform: translateY(-2px);
        }
        .page-btn.active {
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            border-color: transparent; color: white;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
        }
        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
        .page-btn.dots { cursor: default; border: none; background: transparent; }
        .page-btn.dots:hover { background: transparent; transform: none; color: var(--text); }

        /* LOADING */
        .loading-overlay {
            position: absolute; inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            display: none; justify-content: center; align-items: center;
            border-radius: 16px; z-index: 10;
        }
        .loading-overlay.active { display: flex; }
        .spinner-load {
            width: 44px; height: 44px;
            border: 4px solid rgba(37, 99, 235, 0.15);
            border-top-color: #60A5FA;
            border-radius: 50%; animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* EMPTY */
        .empty-state {
            text-align: center; padding: 60px 20px; color: var(--muted);
        }
        .empty-state i {
            font-size: 48px; color: #334155;
            margin-bottom: 16px; display: block;
        }

        /* TOAST */
        .toast {
            position: fixed; top: 24px; right: 24px;
            padding: 14px 24px; border-radius: 12px;
            font-weight: 600; font-size: 14px; color: white;
            transform: translateX(150%);
            transition: transform 0.4s ease;
            z-index: 2000;
            display: flex; align-items: center; gap: 10px;
        }
        .toast.show { transform: translateX(0); }
        .toast.success { background: linear-gradient(135deg, #10B981, #059669); }
        .toast.error { background: linear-gradient(135deg, #EF4444, #B91C1C); }
        .toast.info { background: linear-gradient(135deg, #2563EB, #7C3AED); }

        /* STAT CARDS */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--card);
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid var(--border);
            display: flex; align-items: center; gap: 16px;
        }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .stat-icon.blue { background: rgba(37, 99, 235, 0.15); color: #60A5FA; }
        .stat-icon.purple { background: rgba(124, 58, 237, 0.15); color: #A78BFA; }
        .stat-icon.green { background: rgba(16, 185, 129, 0.15); color: #34D399; }
        .stat-icon.pink { background: rgba(236, 72, 153, 0.15); color: #F472B6; }
        .stat-info h3 { font-size: 24px; font-weight: 800; color: #FFF; }
        .stat-info p { font-size: 12px; color: var(--muted); margin-top: 2px; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .navbar { padding: 14px 18px; }
            .navbar-menu { width: 100%; justify-content: center; }
            .container { padding: 20px 16px; }
            .form-row { flex-direction: column; }
            .form-group { flex: 1 1 100%; }
            .btn-save, .btn-primary { width: 100%; justify-content: center; }
            .pagination-wrapper { flex-direction: column; }
            .toast { top: 16px; right: 16px; left: 16px; }
        }
    </style>
</head>
<body>

<!-- TOAST -->
<div class="toast" id="toast">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg"></span>
</div>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-brand">
        <i class="fas fa-graduation-cap"></i>
        <h1>Ujian ASTS</h1>
    </div>
    <div class="navbar-menu">
        <a class="nav-link active" onclick="switchPage('dashboard')" data-page="dashboard">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a class="nav-link" onclick="switchPage('siswa')" data-page="siswa">
            <i class="fas fa-users"></i> Data Siswa
        </a>
    </div>
    <div style="display:flex; gap:10px; align-items:center;">
        <div class="user-info">
            <i class="fas fa-user-circle"></i>
            Halo, <strong><?= htmlspecialchars($user_nama) ?></strong>
        </div>
        <a href="api/logout.php" class="btn-logout" onclick="return confirm('Yakin ingin logout?')">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</nav>

<!-- MAIN CONTAINER -->
<div class="container">

    <!-- ==================== PAGE: DASHBOARD ==================== -->
    <div class="page active" id="page-dashboard">
        <div class="page-title"><i class="fas fa-home"></i> Dashboard</div>
        <p style="color:#94A3B8; margin-bottom:24px;">Selamat datang di Sistem Informasi Data Siswa</p>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <h3 id="statTotal">0</h3>
                    <p>Total Siswa</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-mars"></i></div>
                <div class="stat-info">
                    <h3 id="statMale">0</h3>
                    <p>Laki-laki</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pink"><i class="fas fa-venus"></i></div>
                <div class="stat-info">
                    <h3 id="statFemale">0</h3>
                    <p>Perempuan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-user-circle"></i></div>
                <div class="stat-info">
                    <h3><?= htmlspecialchars($user_role) ?></h3>
                    <p>Role Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== PAGE: DATA SISWA ==================== -->
    <div class="page" id="page-siswa">
        <div class="page-title"><i class="fas fa-users"></i> Data Siswa</div>

        <!-- SEARCH -->
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="inputCari" placeholder="Cari berdasarkan nama..." onkeyup="cariData()">
        </div>

        <!-- FORM -->
        <div class="form-card">
            <div class="form-row">
                <input type="hidden" id="inputId">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Nama</label>
                    <input type="text" id="inputName" placeholder="Nama lengkap">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> NISN</label>
                    <input type="text" id="inputNisn" placeholder="NISN">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-calendar"></i> TTL</label>
                    <input type="text" id="inputTtl" placeholder="Ponorogo, 12 Agustus 2010">
                </div>
                <div class="form-group">
                    <label><i class="fas fa-venus-mars"></i> Gender</label>
                    <select id="inputGender">
                        <option value="MALE">MALE</option>
                        <option value="FEMALE">FEMALE</option>
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="text" id="inputEmail" placeholder="email@example.com">
                </div>
                <div class="form-group" style="flex: 2 1 200px;">
                    <label><i class="fas fa-map-pin"></i> Alamat</label>
                    <input type="text" id="inputAddress" placeholder="Alamat">
                </div>
                <button class="btn btn-save" onclick="simpanData()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>

        <!-- TABLE -->
        <div class="table-wrapper">
            <div class="loading-overlay" id="loadingOverlay">
                <div class="spinner-load"></div>
            </div>
            <div id="hasil">
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    Belum ada data
                </div>
            </div>
        </div>

        <!-- PAGINATION -->
        <div class="pagination-wrapper" id="paginationWrapper" style="display:none;">
            <div class="pagination-info" id="paginationInfo"></div>
            <div class="pagination-controls" id="paginationControls"></div>
        </div>
    </div>

</div>

<script>
// ============================================================
//  KONFIGURASI
// ============================================================
const API_GET = "api/data_json.php";
const API_CRUD = "api/crud.php";
const perPage = 10;

let dataSiswa = [];
let dataFiltered = [];
let currentPage = 1;

// ============================================================
//  NAVIGASI PAGE
// ============================================================
function switchPage(page) {
    document.querySelectorAll('.page').forEach(el => el.classList.remove('active'));
    document.getElementById('page-' + page).classList.add('active');

    document.querySelectorAll('.nav-link').forEach(el => {
        el.classList.remove('active');
        if (el.dataset.page === page) el.classList.add('active');
    });

    if (page === 'siswa' && dataSiswa.length === 0) {
        loadData();
    }
}

// ============================================================
//  TOAST
// ============================================================
function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    t.className = 'toast ' + type;
    void t.offsetWidth;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
}

// ============================================================
//  LOADING
// ============================================================
function showLoading() { document.getElementById('loadingOverlay').classList.add('active'); }
function hideLoading() { document.getElementById('loadingOverlay').classList.remove('active'); }

// ============================================================
//  READ DATA
// ============================================================
function loadData() {
    showLoading();
    fetch(API_GET)
        .then(r => r.json())
        .then(data => {
            dataSiswa = data;
            dataFiltered = data;
            currentPage = 1;
            updateStats();
            renderData();
            hideLoading();
        })
        .catch(err => {
            document.getElementById('hasil').innerHTML = `
                <div class="empty-state" style="color:#F87171;">
                    <i class="fas fa-exclamation-triangle"></i>
                    Gagal mengambil data
                </div>`;
            hideLoading();
        });
}

// ============================================================
//  STATISTIK
// ============================================================
function updateStats() {
    document.getElementById('statTotal').textContent = dataSiswa.length;
    document.getElementById('statMale').textContent = dataSiswa.filter(i => (i.gender||'').toUpperCase() === 'MALE').length;
    document.getElementById('statFemale').textContent = dataSiswa.filter(i => (i.gender||'').toUpperCase() === 'FEMALE').length;
}

// ============================================================
//  RENDER DATA + PAGINATION
// ============================================================
function renderData() {
    const total = dataFiltered.length;
    if (total === 0) {
        document.getElementById('hasil').innerHTML = `
            <div class="empty-state">
                <i class="fas fa-search"></i>
                Tidak ada data
            </div>`;
        document.getElementById('paginationWrapper').style.display = 'none';
        return;
    }

    const totalPages = Math.ceil(total / perPage);
    if (currentPage > totalPages) currentPage = totalPages;
    if (currentPage < 1) currentPage = 1;

    const start = (currentPage - 1) * perPage;
    const end = Math.min(start + perPage, total);
    const pageData = dataFiltered.slice(start, end);

    let html = `<table>
        <thead><tr>
            <th>No</th><th>ID</th><th>Nama</th><th>NISN</th>
            <th>TTL</th><th>Gender</th><th>Email</th><th>Alamat</th><th>Aksi</th>
        </tr></thead><tbody>`;

    pageData.forEach((item, i) => {
        const no = start + i + 1;
        const gc = (item.gender||'').toUpperCase() === 'FEMALE' ? 'badge-female' : 'badge-male';
        const gt = (item.gender||'MALE').toUpperCase();
        html += `<tr>
            <td><strong>${no}</strong></td>
            <td>${item.id}</td>
            <td>${item.name||'-'}</td>
            <td>${item.nisn||'-'}</td>
            <td>${item.ttl||'-'}</td>
            <td><span class="badge-gender ${gc}">${gt}</span></td>
            <td>${item.email||'-'}</td>
            <td>${item.address||'-'}</td>
            <td><div class="aksi-cell">
                <button class="btn btn-edit" onclick='isiFormEdit(${JSON.stringify(item)})'>
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-delete" onclick="hapusData(${item.id}, '${(item.name||'').replace(/'/g, "\\'")}')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div></td>
        </tr>`;
    });

    html += `</tbody></table>`;
    document.getElementById('hasil').innerHTML = html;
    document.getElementById('paginationInfo').innerHTML = 
        `Menampilkan <strong>${start+1}</strong> - <strong>${end}</strong> dari <strong>${total}</strong> siswa`;
    renderPagination(totalPages);
}

// ============================================================
//  PAGINATION
// ============================================================
function renderPagination(totalPages) {
    const wrap = document.getElementById('paginationWrapper');
    const ctrl = document.getElementById('paginationControls');

    if (totalPages <= 1) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'flex';

    let html = `<button class="page-btn" onclick="goToPage(${currentPage-1})" ${currentPage===1?'disabled':''}>
        <i class="fas fa-chevron-left"></i></button>`;

    getPageNumbers(currentPage, totalPages).forEach(p => {
        if (p === '...') html += `<span class="page-btn dots">...</span>`;
        else html += `<button class="page-btn ${p===currentPage?'active':''}" onclick="goToPage(${p})">${p}</button>`;
    });

    html += `<button class="page-btn" onclick="goToPage(${currentPage+1})" ${currentPage===totalPages?'disabled':''}>
        <i class="fas fa-chevron-right"></i></button>`;

    ctrl.innerHTML = html;
}

function getPageNumbers(c, t) {
    const d = 2, range = [], rwd = [];
    let l;
    for (let i = 1; i <= t; i++) {
        if (i === 1 || i === t || (i >= c - d && i <= c + d)) range.push(i);
    }
    for (let i of range) {
        if (l) {
            if (i - l === 2) rwd.push(l + 1);
            else if (i - l !== 1) rwd.push('...');
        }
        rwd.push(i);
        l = i;
    }
    return rwd;
}

function goToPage(p) {
    const tp = Math.ceil(dataFiltered.length / perPage);
    if (p < 1 || p > tp) return;
    currentPage = p;
    renderData();
    document.querySelector('.table-wrapper').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ============================================================
//  SEARCH
// ============================================================
function cariData() {
    const k = document.getElementById('inputCari').value.toLowerCase();
    dataFiltered = dataSiswa.filter(i => (i.name||'').toLowerCase().includes(k));
    currentPage = 1;
    renderData();
}

// ============================================================
//  SIMPAN (CREATE / UPDATE)
// ============================================================
function simpanData() {
    const id = document.getElementById('inputId').value;
    const name = document.getElementById('inputName').value.trim();
    if (!name) { showToast('Nama wajib diisi!', 'error'); return; }

    const body = {
        id: id || undefined,
        name: name,
        nisn: document.getElementById('inputNisn').value.trim(),
        ttl: document.getElementById('inputTtl').value.trim(),
        gender: document.getElementById('inputGender').value,
        email: document.getElementById('inputEmail').value.trim(),
        address: document.getElementById('inputAddress').value.trim()
    };

    const method = id ? 'PUT' : 'POST';
    showLoading();

    fetch(API_CRUD, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
    })
    .then(r => r.json())
    .then(res => {
        kosongkanForm();
        showToast(id ? '✅ Data diupdate!' : '✅ Data ditambahkan!', 'success');
        loadData();
    })
    .catch(() => { hideLoading(); showToast('❌ Gagal!', 'error'); });
}

// ============================================================
//  EDIT
// ============================================================
function isiFormEdit(item) {
    document.getElementById('inputId').value = item.id;
    document.getElementById('inputName').value = item.name || '';
    document.getElementById('inputNisn').value = item.nisn || '';
    document.getElementById('inputTtl').value = item.ttl || '';
    document.getElementById('inputGender').value = (item.gender||'MALE').toUpperCase();
    document.getElementById('inputEmail').value = item.email || '';
    document.getElementById('inputAddress').value = item.address || '';
    window.scrollTo({ top: 0, behavior: 'smooth' });
    showToast('📝 Edit data', 'info');
}

function kosongkanForm() {
    ['inputId','inputName','inputNisn','inputTtl','inputEmail','inputAddress'].forEach(id => 
        document.getElementById(id).value = ''
    );
    document.getElementById('inputGender').value = 'MALE';
}

// ============================================================
//  HAPUS
// ============================================================
function hapusData(id, name) {
    if (!confirm(`Yakin hapus "${name}"?`)) return;
    showLoading();
    fetch(`${API_CRUD}?id=${id}`, { method: 'DELETE' })
        .then(r => r.json())
        .then(() => { showToast('✅ Data dihapus!', 'success'); loadData(); })
        .catch(() => { hideLoading(); showToast('❌ Gagal!', 'error'); });
}

// ============================================================
//  AUTO LOAD DATA SAAT PERTAMA KALI
// ============================================================
window.addEventListener('DOMContentLoaded', () => {
    loadData();
});
</script>

</body>
</html>