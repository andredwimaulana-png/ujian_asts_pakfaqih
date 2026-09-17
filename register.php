<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Ujian ASTS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(145deg, #0F172A 0%, #1E293B 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            max-width: 420px; width: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 24px; padding: 40px 36px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }
        .header { text-align: center; margin-bottom: 32px; }
        .header .icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #10B981, #059669);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 32px; color: white;
        }
        .header h1 { font-size: 24px; font-weight: 800; color: #FFF; }
        .header p { color: #94A3B8; font-size: 14px; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block; font-size: 13px; font-weight: 600;
            color: #E2E8F0; margin-bottom: 6px;
        }
        .form-group label i { margin-right: 8px; color: #34D399; }
        .form-group input {
            width: 100%; padding: 12px 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px; font-size: 14px;
            font-family: 'Inter', sans-serif; color: #FFF;
            transition: all 0.3s ease; outline: none;
        }
        .form-group input:focus {
            border-color: #10B981;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
        .form-group input::placeholder { color: #64748B; }
        .btn-register {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #10B981, #059669);
            color: white; border: none; border-radius: 12px;
            font-size: 16px; font-weight: 700;
            cursor: pointer; transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center;
            gap: 10px; margin-top: 8px;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.3);
        }
        .btn-register:disabled { opacity: 0.6; cursor: not-allowed; }
        .alert {
            padding: 12px 16px; border-radius: 10px;
            font-size: 13px; margin-bottom: 16px; display: none;
        }
        .alert.success { background: rgba(16, 185, 129, 0.15); color: #6EE7B7; display: block; }
        .alert.error { background: rgba(220, 38, 38, 0.15); color: #FCA5A5; display: block; }
        .footer-link {
            text-align: center; color: #64748B;
            font-size: 13px; margin-top: 20px;
        }
        .footer-link a { color: #34D399; text-decoration: none; font-weight: 600; }
        .spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white; border-radius: 50%;
            animation: spin 0.8s linear infinite; display: none;
        }
        .spinner.active { display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="icon"><i class="fas fa-user-plus"></i></div>
        <h1>Register</h1>
        <p>Buat akun baru</p>
    </div>

    <div id="alert" class="alert"></div>

    <form id="registerForm">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nama Lengkap</label>
            <input type="text" id="nama" placeholder="Nama Anda" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email</label>
            <input type="email" id="email" placeholder="email@example.com" required>
        </div>
        <div class="form-group">
            <label><i class="fas fa-lock"></i> Password</label>
            <input type="password" id="password" placeholder="Minimal 6 karakter" required>
        </div>
        <button type="submit" class="btn-register" id="btnRegister">
            <span id="btnText">Daftar Sekarang</span>
            <span class="spinner" id="spinner"></span>
            <i class="fas fa-arrow-right"></i>
        </button>
    </form>

    <div class="footer-link">
        Sudah punya akun? <a href="index.php">Login</a>
    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const alertBox = document.getElementById('alert');
    const btn = document.getElementById('btnRegister');
    const btnText = document.getElementById('btnText');
    const spinner = document.getElementById('spinner');

    alertBox.className = 'alert';
    btn.disabled = true;
    btnText.textContent = 'Memproses...';
    spinner.classList.add('active');

    const fd = new FormData();
    fd.append('action', 'register');
    fd.append('nama', document.getElementById('nama').value);
    fd.append('email', document.getElementById('email').value);
    fd.append('password', document.getElementById('password').value);

    try {
        const res = await fetch('api/auth.php', { method: 'POST', body: fd });
        const data = await res.json();

        if (data.status) {
            alertBox.className = 'alert success';
            alertBox.textContent = '✅ ' + data.message;
            setTimeout(() => window.location.href = 'index.php', 1500);
        } else {
            alertBox.className = 'alert error';
            alertBox.textContent = '❌ ' + data.message;
            btn.disabled = false;
            btnText.textContent = 'Daftar Sekarang';
            spinner.classList.remove('active');
        }
    } catch (err) {
        alertBox.className = 'alert error';
        alertBox.textContent = '❌ Terjadi kesalahan';
        btn.disabled = false;
        btnText.textContent = 'Daftar Sekarang';
        spinner.classList.remove('active');
    }
});
</script>
</body>
</html>