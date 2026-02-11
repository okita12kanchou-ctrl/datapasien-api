<?php
// api/db.php - Koneksi ke PlanetScale MySQL

function getConnection() {
    // ⚠️ GANTI DENGAN CREDENTIALS ANDA SETELAH BUAT DATABASE DI PLANETSCALE
    $host = 'aws.connect.psdb.cloud';
    $username = 'your_username_here';  // Ganti
    $password = 'your_password_here';  // Ganti
    $database = 'datapasien_db';       // Ganti
    
    // Create connection with SSL for PlanetScale
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, "/etc/ssl/certs/ca-certificates.crt", NULL, NULL);
    
    if (!mysqli_real_connect($conn, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
        error_log("Database connection failed: " . mysqli_connect_error());
        return null;
    }
    
    mysqli_set_charset($conn, "utf8mb4");
    return $conn;
}

// Helper function untuk response JSON
function jsonResponse($success, $message, $data = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
?>
