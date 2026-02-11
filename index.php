<?php
// api/index.php - Main router

// Set headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include database connection
require_once 'db.php';

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Simple routing
switch (true) {
    case $path === '/api' || $path === '/api/':
        echo json_encode([
            'status' => 'API is running',
            'version' => '1.0',
            'endpoints' => [
                'GET /api/get' => 'Get all patients',
                'POST /api/insert' => 'Add new patient',
                'PUT /api/update' => 'Update patient',
                'DELETE /api/delete' => 'Delete patient'
            ]
        ]);
        break;
        
    case $path === '/api/get' && $method === 'GET':
        require 'get.php';
        break;
        
    case $path === '/api/insert' && $method === 'POST':
        require 'insert.php';
        break;
        
    case $path === '/api/update' && $method === 'PUT':
        require 'update.php';
        break;
        
    case $path === '/api/delete' && $method === 'DELETE':
        require 'delete.php';
        break;
        
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
}
?>
