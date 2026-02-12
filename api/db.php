<?php
function getConnection() {
    // 🔥 INFINITYFREE - GRATIS SELAMANYA!
    $host = 'sql308.infinityfree.com';
    $username = 'if0_41109553';
    $password = 'Honkai013';
    $database = 'if0_41109553_datapasien';
    
    $conn = mysqli_connect($host, $username, $password, $database);
    
    if (!$conn) {
        error_log("InfinityFree connection failed: " . mysqli_connect_error());
        return null;
    }
    
    mysqli_set_charset($conn, "utf8mb4");
    return $conn;
}

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
