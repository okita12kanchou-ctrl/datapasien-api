<?php
// api/insert.php - Insert new patient

$conn = getConnection();
if (!$conn) {
    jsonResponse(false, 'Database connection failed');
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['nama'], $input['usia'], $input['keluhan'], $input['nomor_rekam_medis'])) {
    jsonResponse(false, 'All fields are required: nama, usia, keluhan, nomor_rekam_medis');
}

// Sanitize input
$nama = mysqli_real_escape_string($conn, trim($input['nama']));
$usia = (int)$input['usia'];
$keluhan = mysqli_real_escape_string($conn, trim($input['keluhan']));
$nomor_rm = mysqli_real_escape_string($conn, trim($input['nomor_rekam_medis']));

// Validate
if (empty($nama) || empty($keluhan) || empty($nomor_rm)) {
    jsonResponse(false, 'Fields cannot be empty');
}

if ($usia <= 0 || $usia > 150) {
    jsonResponse(false, 'Invalid age');
}

try {
    // Check for duplicate nomor rekam medis
    $checkQuery = "SELECT id FROM pasien WHERE nomor_rekam_medis = '$nomor_rm'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        jsonResponse(false, 'Nomor Rekam Medis already exists');
    }
    
    // Insert data
    $query = "INSERT INTO pasien (nama, usia, keluhan, nomor_rekam_medis, created_at) 
              VALUES ('$nama', $usia, '$keluhan', '$nomor_rm', NOW())";
    
    if (mysqli_query($conn, $query)) {
        $newId = mysqli_insert_id($conn);
        jsonResponse(true, 'Patient added successfully', ['id' => $newId]);
    } else {
        jsonResponse(false, 'Insert failed: ' . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    jsonResponse(false, 'Error: ' . $e->getMessage());
} finally {
    mysqli_close($conn);
}
?>
