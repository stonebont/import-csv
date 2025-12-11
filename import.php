<?php
header('Content-Type: application/json');

// --- Konfigurasi Database ---
$servername = "localhost";
$username   = "your_database"; // Ganti dengan username Anda
$password   = "your_password";     // Ganti dengan password Anda
$dbname     = "your_database";
$table      = "tbl_bosda";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Koneksi database gagal: ' . $conn->connect_error]);
    exit();
}

// Menerima data JSON dari permintaan POST
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (empty($data)) {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada data yang diterima.']);
    exit();
}

$count = 0;
$stmt = $conn->prepare("INSERT INTO $table (npsn, tahun, jml_bosda) VALUES (?, ?, ?)");

// Sesuaikan 'sss' berdasarkan tipe data kolom Anda (s=string, i=integer, d=double, b=blob)
$stmt->bind_param("ssi", $npsn, $tahun, $jml_bosda);

foreach ($data as $row) {
    // Memastikan kunci ada dan melakukan sanitasi dasar
    $npsn = htmlspecialchars($row['npsn'] ?? '');
    $tahun = htmlspecialchars($row['tahun'] ?? '');
    $jml_bosda = htmlspecialchars($row['jml_bosda'] ?? '');

    // Eksekusi statement
    if ($stmt->execute()) {
        $count++;
    } else {
        // Handle error per baris jika diperlukan
        // echo json_encode(['status' => 'error', 'message' => 'Gagal memasukkan baris: ' . $stmt->error]);
    }
}

$stmt->close();
$conn->close();

echo json_encode(['status' => 'success', 'count' => $count, 'message' => 'Import berhasil.']);
?>
