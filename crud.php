<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$database = "ujian_asts";
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    echo json_encode(["message" => "Koneksi gagal: " . mysqli_connect_error()]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, nisn, ttl, gender, email, address) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss",
            $input['name'] ?? '',
            $input['nisn'] ?? '',
            $input['ttl'] ?? '',
            $input['gender'] ?? 'MALE',
            $input['email'] ?? '',
            $input['address'] ?? ''
        );
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "Data berhasil ditambahkan"]);
        } else {
            echo json_encode(["message" => "Gagal: " . mysqli_error($conn)]);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = mysqli_prepare($conn, "UPDATE users SET name=?, nisn=?, ttl=?, gender=?, email=?, address=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssssi",
            $input['name'] ?? '',
            $input['nisn'] ?? '',
            $input['ttl'] ?? '',
            $input['gender'] ?? 'MALE',
            $input['email'] ?? '',
            $input['address'] ?? '',
            $input['id'] ?? 0
        );
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "Data berhasil diupdate"]);
        } else {
            echo json_encode(["message" => "Gagal: " . mysqli_error($conn)]);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? 0;
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "Data berhasil dihapus"]);
        } else {
            echo json_encode(["message" => "Gagal: " . mysqli_error($conn)]);
        }
        break;

    default:
        echo json_encode(["message" => "Method tidak didukung"]);
}

mysqli_close($conn);
?>