<?php
// db.php - TiDB Serverless Version
function getConnection() {
    // ✅ CREDENTIALS ANDA - SUDAH DIISI
    $host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
    $username = '49zgvUBnTmZRAoP.root';
    $password = 'dkWpq02Qr5wczcQG';
    $database = 'test';  // PAKAI 'test' dulu
    
    $conn = mysqli_init();
    
    // TiDB WAJIB PAKAI SSL
    mysqli_ssl_set($conn, NULL, NULL, "/etc/ssl/certs/ca-certificates.crt", NULL, NULL);
    
    if (!mysqli_real_connect($conn, $host, $username, $password, $database, 4000, NULL, MYSQLI_CLIENT_SSL)) {
        error_log("TiDB Connection failed: " . mysqli_connect_error());
        return null;
    }
    
    mysqli_set_charset($conn, "utf8mb4");
    return $conn;
}

function jsonResponse($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data !== null) $response['data'] = $data;
    
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    exit;
}
?>
