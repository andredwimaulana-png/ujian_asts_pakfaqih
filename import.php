<?php
// 1. Koneksi ke Database MySQL (Database: data_api, Port: 3306)
$host     = "localhost";
$user     = "root";
$password = "";
$database = "data_api";
$port     = 3306;

$conn = mysqli_connect($host, $user, $password, $database, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// 2. Mengambil data JSON langsung dari internet (JSONPlaceholder)
$url = "https://jsonplaceholder.typicode.com/users";
$json_data = file_get_contents($url);

// 3. Mengubah string JSON menjadi Array PHP
$users = json_decode($json_data, true);

// 4. Perulangan untuk memasukkan ke-10 data ke tabel users
$jumlah_berhasil = 0;

foreach ($users as $user) {
    $id       = $user['id'];
    $name     = mysqli_real_escape_string($conn, $user['name']);
    $username = mysqli_real_escape_string($conn, $user['username']);
    
    // Menggabungkan street & city menjadi alamat lengkap
    $address  = mysqli_real_escape_string($conn, $user['address']['street'] . ', ' . $user['address']['city']);

    // Query INSERT (ON DUPLICATE KEY UPDATE mencegah error jika ID sudah ada)
    $sql = "INSERT INTO users (id, name, username, address) 
            VALUES ('$id', '$name', '$username', '$address')
            ON DUPLICATE KEY UPDATE 
                name='$name', 
                username='$username', 
                address='$address'";
    
    if (mysqli_query($conn, $sql)) {
        $jumlah_berhasil++;
    }   
}

echo "MR Andzvg (PAK FAQIH) - Berhasil mengimpor $jumlah_berhasil data user ke database MySQL!";

mysqli_close($conn);
?>