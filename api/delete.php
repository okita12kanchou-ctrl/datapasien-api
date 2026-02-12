<?php
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

try {
    $query = "DELETE FROM pasien WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            jsonResponse(true, 'Patient deleted successfully');
        } else {
            jsonResponse(false, 'Patient not found');
        }
    } else {
        jsonResponse(false, 'Delete failed: ' . mysqli_error($conn));
    }
    
} catch (Exception $e) {
    jsonResponse(false, 'Error: ' . $e->getMessage());
} finally {
    mysqli_close($conn);
}
?>
