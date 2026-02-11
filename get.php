<?php
// api/get.php - Get all patients

$conn = getConnection();
if (!$conn) {
    jsonResponse(false, 'Database connection failed');
}

try {
    $query = "SELECT * FROM pasien ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        jsonResponse(false, 'Query failed: ' . mysqli_error($conn));
    }
    
    $patients = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = [
            'id' => (int)$row['id'],
            'nama' => $row['nama'],
            'usia' => (int)$row['usia'],
            'keluhan' => $row['keluhan'],
            'nomor_rekam_medis' => $row['nomor_rekam_medis'],
            'created_at' => $row['created_at'] ?? null
        ];
    }
    
    jsonResponse(true, 'Data retrieved successfully', $patients);
    
} catch (Exception $e) {
    jsonResponse(false, 'Error: ' . $e->getMessage());
} finally {
    mysqli_close($conn);
}
?>
