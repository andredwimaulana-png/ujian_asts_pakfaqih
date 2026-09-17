<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$host     = "localhost";
$user     = "root";
$password = "";
$database = "ujian_asts";
$port     = 3306;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    echo json_encode(["message" => "Koneksi gagal: " . mysqli_connect_error()]);
    exit();
}

// Ambil data dari tabel users (data siswa)
$sql = "SELECT id, name, nisn, ttl, gender, email, address FROM users ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(["message" => "Query error: " . mysqli_error($conn)]);
    exit();
}

$users = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

echo json_encode($users, JSON_PRETTY_PRINT);

mysqli_close($conn);
?>