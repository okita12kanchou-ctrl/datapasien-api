<?php
// index.php - API Information & Status
require_once 'db.php';

// Test database connection
$db_status = 'Unknown';
$db_message = '';
$total_pasien = 0;

$conn = getConnection();
if ($conn) {
    $db_status = 'Connected';
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM pasien");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $total_pasien = $row['total'];
        $db_message = 'Database connected successfully';
    } else {
        $db_message = 'Table pasien belum ada atau error: ' . mysqli_error($conn);
    }
    mysqli_close($conn);
} else {
    $db_status = 'Failed';
    $db_message = 'Database connection failed - cek credentials';
}

// API Information
$response = [
    'status' => 'online',
    'message' => 'Data Pasien Klinik API',
    'version' => '1.0.0',
    'server_time' => date('Y-m-d H:i:s'),
    'timezone' => date_default_timezone_get(),
    'database' => [
        'type' => 'TiDB Serverless',
        'status' => $db_status,
        'message' => $db_message,
        'total_pasien' => $total_pasien
    ],
    'endpoints' => [
        [
            'method' => 'GET',
            'url' => '/get.php',
            'description' => 'Ambil semua data pasien'
        ],
        [
            'method' => 'POST',
            'url' => '/insert.php',
            'description' => 'Tambah pasien baru',
            'body' => [
                'nama' => 'string',
                'usia' => 'integer',
                'keluhan' => 'string',
                'nomor_rekam_medis' => 'string (unique)'
            ]
        ],
        [
            'method' => 'PUT',
            'url' => '/update.php',
            'description' => 'Update data pasien',
            'body' => [
                'id' => 'integer',
                'nama' => 'string (optional)',
                'usia' => 'integer (optional)',
                'keluhan' => 'string (optional)',
                'nomor_rekam_medis' => 'string (optional)'
            ]
        ],
        [
            'method' => 'DELETE',
            'url' => '/delete.php',
            'description' => 'Hapus pasien',
            'body' => [
                'id' => 'integer'
            ]
        ]
    ],
    'example_requests' => [
        'get_all' => 'GET https://datapasien-api.vercel.app/get.php',
        'insert' => 'POST https://datapasien-api.vercel.app/insert.php',
        'update' => 'PUT https://datapasien-api.vercel.app/update.php',
        'delete' => 'DELETE https://datapasien-api.vercel.app/delete.php'
    ],
    'developer' => 'Created for Data Pasien Klinik Android App',
    'contact' => 'support@datapasienklinik.com'
];

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Output JSON with pretty print
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
