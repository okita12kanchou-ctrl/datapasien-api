<?php
function getConnection() {
    // 🔥 RAILWAY MYSQL - GRATIS 1GB!
    $host = 'mysql.railway.internal';
    $port = 3306;
    $username = 'root';
    $password = 'hrnpbMQqAWdhYedqRyItKMVJftzVbbjw';
    $database = 'railway';
    
    $conn = mysqli_connect($host, $username, $password, $database, $port);
    
    if (!$conn) {
        error_log("Railway MySQL connection failed: " . mysqli_connect_error());
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
