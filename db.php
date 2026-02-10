<?php
function getConnection() {
    // NANTI DIISI SETELAH BUAT DATABASE
    $host = 'aws.connect.psdb.cloud';
    $username = 'isi_nanti';
    $password = 'isi_nanti';
    $database = 'datapasien_db';
    
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, "/etc/ssl/certs/ca-certificates.crt", NULL, NULL);
    
    if (!mysqli_real_connect($conn, $host, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
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
