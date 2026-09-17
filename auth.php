<?php
session_start();
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$password = "";
$database = "ujian_asts";
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    echo json_encode(["status" => false, "message" => "Koneksi gagal"]);
    exit();
}

$action = $_POST['action'] ?? '';

// ============================================================
// LOGIN
// ============================================================
if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (empty($email) || empty($pass)) {
        echo json_encode(["status" => false, "message" => "Email dan password wajib diisi"]);
        exit();
    }

    $stmt = $conn->prepare("SELECT id, nama, email, password, role FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["status" => false, "message" => "Email tidak terdaftar"]);
        exit();
    }

    $userData = $result->fetch_assoc();

    if (!password_verify($pass, $userData['password'])) {
        echo json_encode(["status" => false, "message" => "Password salah"]);
        exit();
    }

    $_SESSION['user_id'] = $userData['id'];
    $_SESSION['user_nama'] = $userData['nama'];
    $_SESSION['user_email'] = $userData['email'];
    $_SESSION['user_role'] = $userData['role'];

    echo json_encode([
        "status" => true,
        "message" => "Login berhasil!",
        "data" => [
            "id" => $userData['id'],
            "nama" => $userData['nama'],
            "email" => $userData['email'],
            "role" => $userData['role']
        ]
    ]);
    exit();
}

// ============================================================
// REGISTER
// ============================================================
if ($action === 'register') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (empty($nama) || empty($email) || empty($pass)) {
        echo json_encode(["status" => false, "message" => "Semua data wajib diisi"]);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => false, "message" => "Format email tidak valid"]);
        exit();
    }

    if (strlen($pass) < 6) {
        echo json_encode(["status" => false, "message" => "Password minimal 6 karakter"]);
        exit();
    }

    $cek = $conn->prepare("SELECT id FROM admin_users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();
    if ($cek->get_result()->num_rows > 0) {
        echo json_encode(["status" => false, "message" => "Email sudah terdaftar"]);
        exit();
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO admin_users (nama, email, password, role) VALUES (?, ?, ?, 'user')");
    $stmt->bind_param("sss", $nama, $email, $hash);

    if ($stmt->execute()) {
        echo json_encode(["status" => true, "message" => "Registrasi berhasil! Silakan login."]);
    } else {
        echo json_encode(["status" => false, "message" => "Registrasi gagal: " . $conn->error]);
    }
    exit();
}

echo json_encode(["status" => false, "message" => "Action tidak valid"]);
?>