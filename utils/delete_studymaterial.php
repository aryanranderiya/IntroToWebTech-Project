<?php
include 'config.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Fetch the file information from the database
    $query = "SELECT file_path FROM study_materials WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $fileData = mysqli_fetch_assoc($result);
        $filePath = $fileData['file_path'];

        // Proceed with deletion from the database
        $deleteQuery = "DELETE FROM study_materials WHERE id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, 'i', $id);
        mysqli_stmt_execute($deleteStmt);

        if (mysqli_stmt_affected_rows($deleteStmt) > 0) {
            echo "File deleted successfully.";
        } else {
            echo "Failed to delete the file.";
        }

        mysqli_stmt_close($deleteStmt);
    } else {
        echo "File not found.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}
