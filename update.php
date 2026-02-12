<?php
// update.php - Update patient
require_once 'db.php';

$conn = getConnection();
if (!$conn) {
    jsonResponse(false, 'Database connection failed');
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate
if (!isset($input['id'])) {
    jsonResponse(false, 'Patient ID is required');
}

$id = (int)$input['id'];
$nama = isset($input['nama']) ? mysqli_real_escape_string($conn, trim($input['nama'])) : null;
$usia = isset($input['usia']) ? (int)$input['usia'] : null;
$keluhan = isset($input['keluhan']) ? mysqli_real_escape_string($conn, trim($input['keluhan'])) : null;
$nomor_rm = isset($input['nomor_rekam_medis']) ? mysqli_real_escape_string($conn, trim($input['nomor_rekam_medis'])) : null;

try {
    // Build update query
    $updates = [];
    if ($nama !== null) $updates[] = "nama = '$nama'";
    if ($usia !== null) $updates[] = "usia = $usia";
    if ($keluhan !== null) $updates[] = "keluhan = '$keluhan'";
    if ($nomor_rm !== null) $updates[] = "nomor_rekam_medis = '$nomor_rm'";
    
    if (empty($updates)) {
        jsonResponse(false, 'No fields to update');
    }
    
    $query = "UPDATE pasien SET " . implode(', ', $updates) . " WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            jsonResponse(true, 'Patient updated successfully');
        } else {
            jsonResponse(false, 'Patient not found or no changes made');
        }
    } else {
        jsonResponse(false, 'Update failed: ' . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    jsonResponse(false, 'Error: ' . $e->getMessage());
} finally {
    mysqli_close($conn);
}
?>
