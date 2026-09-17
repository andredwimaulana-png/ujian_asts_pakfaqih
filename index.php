<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian ASTS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2563EB;
            --secondary: #7C3AED;
            --green: #10B981;
            --red: #DC2626;
            --bg-dark: #0F172A;
            --bg-card: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.08);
            --text-main: #F1F5F9;
            --text-muted: #94A3B8;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(145deg, #0F172A 0%, #1E293B 100%);
            color: var(--text-main);
        }

        .view {
            display: none;
            min-height: 100vh;
        }

        .view.active {
            display: block;
        }

        /* ===================== LOGIN ===================== */
        #viewLogin {
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
        }

        #viewLogin.active {
            display: flex;
        }

        .login-box {
            max-width: 420px;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px 36px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header .icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px;
            color: white;
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: #FFF;
        }

        .login-header p {
            color: #94A3B8;
            font-size: 14px;
            margin-top: 4px;
        }

        .login-group {
            margin-bottom: 18px;
        }

        .login-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #E2E8F0;
            margin-bottom: 6px;
        }

        .login-group label i {
            margin-right: 8px;
            color: #60A5FA;
        }

        .login-group input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #FFF;
            transition: all 0.3s ease;
            outline: none;
        }

        .login-group input:focus {
            border-color: #2563EB;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .login-group input::placeholder {
            color: #64748B;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.3);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 16px;
            display: none;
        }

        .alert.success {
            background: rgba(16, 185, 129, 0.15);
            color: #6EE7B7;
            display: block;
        }

        .alert.error {
            background: rgba(220, 38, 38, 0.15);
            color: #FCA5A5;
            display: block;
        }

        .footer-link {
            text-align: center;
            color: #64748B;
            font-size: 13px;
            margin-top: 20px;
        }

        .footer-link a {
            color: #60A5FA;
            text-decoration: none;
            font-weight: 600;
        }

        .spin-sm {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        .spin-sm.active {
            display: inline-block;
        }

        /* ===================== DASHBOARD ===================== */
        #viewDashboard {
            padding: 24px 20px;
            display: none;
            justify-content: center;
            align-items: flex-start;
        }

        #viewDashboard.active {
            display: flex;
        }

        .container {
            max-width: 1280px;
            width: 100%;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 32px 36px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .header h1 {
            font-size: 26px;
            font-weight: 800;
            background: linear-gradient(135deg, #60A5FA, #A78BFA);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1 i {
            color: #60A5FA;
            -webkit-text-fill-color: #60A5FA;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .badge {
            background: rgba(37, 99, 235, 0.15);
            color: #60A5FA;
            padding: 4px 14px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            background: var(--bg-card);
            padding: 4px 4px 4px 20px;
            border-radius: 60px;
            border: 1px solid var(--border);
            max-width: 400px;
        }

        .search-wrap i {
            color: var(--text-muted);
        }

        .search-wrap input {
            flex: 1;
            padding: 10px;
            background: transparent;
            border: none;
            color: var(--text-main);
            font-size: 14px;
            outline: none;
        }

        .search-wrap input::placeholder {
            color: var(--text-muted);
        }

        .form-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            border: 1px solid var(--border);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: flex-end;
        }

        .form-group {
            flex: 1 1 150px;
            min-width: 130px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-group label i {
            margin-right: 4px;
            color: #60A5FA;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            color: var(--text-main);
            font-size: 13px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-group select option {
            background: #1E293B;
            color: #F1F5F9;
        }

        .btn {
            padding: 11px 24px;
            border: none;
            border-radius: 40px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: scale(0.97);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            color: white;
            box-shadow: 0 4px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 8px 30px rgba(37, 99, 235, 0.4);
        }

        .btn-save {
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-save:hover {
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4);
        }

        .btn-logout {
            background: rgba(220, 38, 38, 0.15);
            color: #F87171;
        }

        .btn-logout:hover {
            background: rgba(220, 38, 38, 0.25);
        }

        .btn-edit {
            background: rgba(37, 99, 235, 0.15);
            color: #60A5FA;
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 30px;
        }

        .btn-edit:hover {
            background: rgba(37, 99, 235, 0.25);
        }

        .btn-delete {
            background: rgba(220, 38, 38, 0.15);
            color: #F87171;
            padding: 6px 14px;
            font-size: 12px;
            border-radius: 30px;
        }

        .btn-delete:hover {
            background: rgba(220, 38, 38, 0.25);
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
            font-size: 13px;
        }

        thead {
            background: rgba(37, 99, 235, 0.1);
        }

        th {
            text-align: left;
            padding: 14px 16px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #93C5FD;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            color: var(--text-main);
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.02);
        }

        tbody tr:hover {
            background: rgba(37, 99, 235, 0.08);
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge-gender {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-male {
            background: rgba(37, 99, 235, 0.15);
            color: #60A5FA;
        }

        .badge-female {
            background: rgba(236, 72, 153, 0.15);
            color: #F472B6;
        }

        .aksi-cell {
            display: flex;
            gap: 8px;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .pagination-info {
            color: var(--text-muted);
            font-size: 13px;
        }

        .pagination-info strong {
            color: #60A5FA;
            font-weight: 700;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .page-btn {
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-main);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .page-btn:hover:not(:disabled) {
            background: rgba(37, 99, 235, 0.15);
            border-color: rgba(37, 99, 235, 0.3);
            color: #60A5FA;
            transform: translateY(-2px);
        }

        .page-btn.active {
            background: linear-gradient(135deg, #2563EB, #7C3AED);
            border-color: transparent;
            color: white;
            box-shadow: 0 4px 16px rgba(37, 99, 235, 0.35);
        }

        .page-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .page-btn.dots {
            cursor: default;
            border: none;
            background: transparent;
            color: var(--text-muted);
        }

        .page-btn.dots:hover {
            background: transparent;
            transform: none;
            color: var(--text-muted);
        }

        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            border-radius: 16px;
            z-index: 10;
        }

        .loading-overlay.active {
            display: flex;
        }

        .spinner {
            width: 44px;
            height: 44px;
            border: 4px solid rgba(37, 99, 235, 0.15);
            border-top-color: #60A5FA;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            color: #334155;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state small {
            display: block;
            margin-top: 6px;
            color: #475569;
        }

        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            color: white;
            transform: translateX(150%);
            transition: transform 0.4s ease;
            z-index: 2000;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.success {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .toast.error {
            background: linear-gradient(135deg, #EF4444, #B91C1C);
        }

        .toast.info {
            background: linear-gradient(135deg, #2563EB, #7C3AED);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 16px;
                border-radius: 20px;
            }

            .header h1 {
                font-size: 20px;
            }

            .form-row {
                flex-direction: column;
            }

            .form-group {
                flex: 1 1 100%;
            }

            .btn-save,
            .btn-primary {
                width: 100%;
                justify-content: center;
            }

            .toast {
                top: 16px;
                right: 16px;
                left: 16px;
            }

            .pagination-wrapper {
                flex-direction: column;
            }

            .pagination-controls {
                justify-content: center;
            }

            .page-btn {
                min-width: 34px;
                height: 34px;
                padding: 0 8px;
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="toast" id="toast">
        <i class="fas fa-check-circle"></i>
        <span id="toastMsg"></span>
    </div>

    <!-- ===================== LOGIN VIEW ===================== -->
    <div id="viewLogin" class="view">
        <div class="login-box">
            <div class="login-header">
                <div class="icon"><i class="fas fa-sign-in-alt"></i></div>
                <h1>Login</h1>
                <p>Masuk ke Dashboard Ujian ASTS</p>
            </div>
            <div id="alert" class="alert"></div>
            <form id="loginForm">
                <div class="login-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" placeholder="admin@sekolah.com" required>
                </div>
                <div class="login-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-login" id="btnLogin">
                    <span id="btnText">Login</span>
                    <span class="spin-sm" id="spinner"></span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
            <div class="footer-link">
                Belum punya akun? <a href="register.php">Daftar Sekarang</a>
            </div>
        </div>
    </div>

    <!-- ===================== DASHBOARD VIEW ===================== -->
    <div id="viewDashboard" class="view">
        <div class="container">
            <div class="header">
                <h1><i class="fas fa-graduation-cap"></i> Ujian ASTS <span class="badge">Data Siswa</span></h1>
                <div class="header-actions">
                    <button class="btn btn-primary" onclick="loadData()">
                        <i class="fas fa-sync-alt"></i> Tampilkan Data
                    </button>
                    <button class="btn btn-logout" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </div>
            </div>

            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" id="inputCari" placeholder="Cari berdasarkan nama..." onkeyup="cariData()">
            </div>

            <div class="form-card">
                <div class="form-row">
                    <input type="hidden" id="inputId">

                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nama</label>
                        <input type="text" id="inputName" placeholder="Nama lengkap">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i> NISN</label>
                        <input type="text" id="inputNisn" placeholder="Nomor NISN">
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
                        <input type="text" id="inputAddress" placeholder="Alamat lengkap">
                    </div>
                    <button class="btn btn-save" onclick="simpanData()">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>

            <div class="table-wrapper">
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="spinner"></div>
                </div>
                <div id="hasil">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        Belum ada data
                        <small>Klik "Tampilkan Data" untuk memuat</small>
                    </div>
                </div>
            </div>

            <div class="pagination-wrapper" id="paginationWrapper" style="display: none;">
                <div class="pagination-info" id="paginationInfo"></div>
                <div class="pagination-controls" id="paginationControls"></div>
            </div>
        </div>
    </div>

    <script>
        const PHP_LOGGED_IN = "<?php echo !empty($isLoggedIn) ? '1' : '0'; ?>" === "1";

        const API_AUTH = "auth.php";
        const API_LOGOUT = "logout.php";
        const API_GET = "data_json.php";
        const API_CRUD = "crud.php";

        let dataUsers = [];
        let dataFiltered = [];
        let currentPage = 1;
        const perPage = 10;

        function showView(name) {
            document.getElementById('viewLogin').classList.toggle('active', name === 'login');
            document.getElementById('viewDashboard').classList.toggle('active', name === 'dashboard');
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const msg = document.getElementById('toastMsg');
            msg.textContent = message;
            toast.className = `toast ${type}`;
            void toast.offsetWidth;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function showLoading() { document.getElementById('loadingOverlay').classList.add('active'); }
        function hideLoading() { document.getElementById('loadingOverlay').classList.remove('active'); }

        /* ===================== AUTH ===================== */
        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const alertBox = document.getElementById('alert');
            const btn = document.getElementById('btnLogin');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');

            alertBox.className = 'alert';
            btn.disabled = true;
            btnText.textContent = 'Memproses...';
            spinner.classList.add('active');

            const fd = new FormData();
            fd.append('action', 'login');
            fd.append('email', document.getElementById('email').value);
            fd.append('password', document.getElementById('password').value);

            try {
                const res = await fetch(API_AUTH, { method: 'POST', body: fd });
                const data = await res.json();
                if (data.status) {
                    alertBox.className = 'alert success';
                    alertBox.textContent = '✅ ' + data.message;
                    setTimeout(() => {
                        showView('dashboard');
                        loadData();
                    }, 800);
                } else {
                    alertBox.className = 'alert error';
                    alertBox.textContent = '❌ ' + data.message;
                    btn.disabled = false;
                    btnText.textContent = 'Login';
                    spinner.classList.remove('active');
                }
            } catch (err) {
                alertBox.className = 'alert error';
                alertBox.textContent = '❌ Terjadi kesalahan. Pastikan api/auth.php berjalan.';
                btn.disabled = false;
                btnText.textContent = 'Login';
                spinner.classList.remove('active');
            }
        });

        function logout() {
            fetch(API_AUTH, {
                method: 'POST',
                body: (() => { const fd = new FormData(); fd.append('action', 'logout'); return fd; })()
            }).catch(() => { });
            document.getElementById('loginForm').reset();
            document.getElementById('alert').className = 'alert';
            document.getElementById('btnLogin').disabled = false;
            document.getElementById('btnText').textContent = 'Login';
            document.getElementById('spinner').classList.remove('active');
            kosongkanForm();
            dataUsers = [];
            dataFiltered = [];
            document.getElementById('hasil').innerHTML = `
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                Belum ada data
                <small>Klik "Tampilkan Data" untuk memuat</small>
            </div>`;
            document.getElementById('paginationWrapper').style.display = 'none';
            showView('login');
            showToast('Berhasil logout', 'info');
        }

        /* ===================== READ ===================== */
        function loadData() {
            showLoading();
            fetch(API_GET)
                .then(response => response.json())
                .then(data => {
                    dataUsers = data;
                    dataFiltered = data;
                    currentPage = 1;
                    renderData();
                    hideLoading();
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById("hasil").innerHTML = `
                    <div class="empty-state" style="color:#F87171;">
                        <i class="fas fa-exclamation-triangle"></i>
                        Gagal mengambil data dari server lokal.
                        <small>Pastikan server berjalan di http://localhost/ujian_asts/</small>
                    </div>`;
                    document.getElementById('paginationWrapper').style.display = 'none';
                    hideLoading();
                });
        }

        function escapeHtml(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function renderData() {
            const totalData = dataFiltered.length;

            if (totalData === 0) {
                document.getElementById("hasil").innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-search"></i>
                    Tidak ada data ditemukan
                    <small>Coba kata kunci lain atau tambahkan data baru</small>
                </div>`;
                document.getElementById('paginationWrapper').style.display = 'none';
                return;
            }

            const totalPages = Math.ceil(totalData / perPage);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const startIndex = (currentPage - 1) * perPage;
            const endIndex = Math.min(startIndex + perPage, totalData);
            const dataPage = dataFiltered.slice(startIndex, endIndex);

            let html = `<table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>NISN</th>
                    <th>TTL</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>`;

            dataPage.forEach((item, index) => {
                const nomorUrut = startIndex + index + 1;
                const genderClass = (item.gender || '').toUpperCase() === 'FEMALE' ? 'badge-female' : 'badge-male';
                const genderText = (item.gender || 'MALE').toUpperCase();
                const safeId = Number(item.id) || 0;

                html += `<tr id="row-${safeId}" data-id="${safeId}">
                <td><strong>${nomorUrut}</strong></td>
                <td>${escapeHtml(item.id)}</td>
                <td>${escapeHtml(item.name || '-')}</td>
                <td>${escapeHtml(item.nisn || '-')}</td>
                <td>${escapeHtml(item.ttl || '-')}</td>
                <td><span class="badge-gender ${genderClass}">${escapeHtml(genderText)}</span></td>
                <td>${escapeHtml(item.email || '-')}</td>
                <td>${escapeHtml(item.address || '-')}</td>
                <td>
                    <div class="aksi-cell">
                        <button class="btn btn-edit" onclick="isiFormEditById(${safeId})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-delete" onclick="hapusData(${safeId})">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>`;
            });

            html += `</tbody></table>`;
            document.getElementById("hasil").innerHTML = html;
            document.getElementById('paginationInfo').innerHTML =
                `Menampilkan <strong>${startIndex + 1}</strong> - <strong>${endIndex}</strong> dari <strong>${totalData}</strong> siswa`;
            renderPagination(totalPages);
        }

        function renderPagination(totalPages) {
            const wrapper = document.getElementById('paginationWrapper');
            const controls = document.getElementById('paginationControls');

            if (totalPages <= 1) {
                wrapper.style.display = 'none';
                return;
            }
            wrapper.style.display = 'flex';

            let html = `<button class="page-btn" onclick="goToPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
            <i class="fas fa-chevron-left"></i>
        </button>`;

            getPageNumbers(currentPage, totalPages).forEach(p => {
                if (p === '...') {
                    html += `<span class="page-btn dots">...</span>`;
                } else {
                    html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goToPage(${p})">${p}</button>`;
                }
            });

            html += `<button class="page-btn" onclick="goToPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
            <i class="fas fa-chevron-right"></i>
        </button>`;

            controls.innerHTML = html;
        }

        function getPageNumbers(current, total) {
            const delta = 2;
            const range = [];
            const rangeWithDots = [];
            let l;

            for (let i = 1; i <= total; i++) {
                if (i === 1 || i === total || (i >= current - delta && i <= current + delta)) {
                    range.push(i);
                }
            }

            for (let i of range) {
                if (l) {
                    if (i - l === 2) rangeWithDots.push(l + 1);
                    else if (i - l !== 1) rangeWithDots.push('...');
                }
                rangeWithDots.push(i);
                l = i;
            }
            return rangeWithDots;
        }

        function goToPage(page) {
            const totalPages = Math.ceil(dataFiltered.length / perPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderData();
            document.querySelector('.table-wrapper').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function cariData() {
            const keyword = document.getElementById('inputCari').value.toLowerCase();
            dataFiltered = dataUsers.filter(item =>
                (item.name || '').toLowerCase().includes(keyword)
            );
            currentPage = 1;
            renderData();
        }

        function simpanData() {
            const id = document.getElementById('inputId').value;
            const name = document.getElementById('inputName').value.trim();
            const nisn = document.getElementById('inputNisn').value.trim();
            const ttl = document.getElementById('inputTtl').value.trim();
            const gender = document.getElementById('inputGender').value;
            const email = document.getElementById('inputEmail').value.trim();
            const address = document.getElementById('inputAddress').value.trim();

            if (!name) {
                showToast('Nama wajib diisi!', 'error');
                return;
            }

            const method = id ? 'PUT' : 'POST';
            const body = id
                ? { id, name, nisn, ttl, gender, email, address }
                : { name, nisn, ttl, gender, email, address };

            showLoading();

            fetch(API_CRUD, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(body)
            })
                .then(response => response.json())
                .then(() => {
                    kosongkanForm();
                    showToast(id ? '✅ Data berhasil diupdate!' : '✅ Data berhasil ditambahkan!', 'success');
                    loadData();
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();
                    showToast('❌ Gagal menyimpan data!', 'error');
                });
        }

        function isiFormEditById(id) {
            const item = dataUsers.find(u => Number(u.id) === Number(id));
            if (!item) {
                showToast('Data tidak ditemukan', 'error');
                return;
            }
            document.getElementById('inputId').value = item.id;
            document.getElementById('inputName').value = item.name || '';
            document.getElementById('inputNisn').value = item.nisn || '';
            document.getElementById('inputTtl').value = item.ttl || '';
            document.getElementById('inputGender').value = (item.gender || 'MALE').toUpperCase();
            document.getElementById('inputEmail').value = item.email || '';
            document.getElementById('inputAddress').value = item.address || '';
            window.scrollTo({ top: 0, behavior: 'smooth' });
            showToast('📝 Silakan edit data', 'info');
        }

        function kosongkanForm() {
            document.getElementById('inputId').value = '';
            document.getElementById('inputName').value = '';
            document.getElementById('inputNisn').value = '';
            document.getElementById('inputTtl').value = '';
            document.getElementById('inputGender').value = 'MALE';
            document.getElementById('inputEmail').value = '';
            document.getElementById('inputAddress').value = '';
        }

        function hapusData(id) {
            const item = dataUsers.find(u => Number(u.id) === Number(id));
            const name = item ? (item.name || '') : '';
            if (!confirm(`Yakin ingin menghapus data "${name}"?`)) return;

            showLoading();
            fetch(`${API_CRUD}?id=${id}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(() => {
                    showToast('✅ Data berhasil dihapus!', 'success');
                    loadData();
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideLoading();
                    showToast('❌ Gagal menghapus data!', 'error');
                });
        }

        /* ===================== INIT ===================== */
        if (PHP_LOGGED_IN) {
            showView('dashboard');
            loadData();
        } else {
            showView('login');
        }
    </script>
</body>

</html>