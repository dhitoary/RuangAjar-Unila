<?php
require_once 'src/config/database.php';

// Check if foto_profil column already exists in mahasiswa table
$check_query = "SHOW COLUMNS FROM mahasiswa LIKE 'foto_profil'";
$result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($result) == 0) {
    echo "Adding foto_profil column to mahasiswa table...\n";
    $alter_query = "ALTER TABLE mahasiswa ADD COLUMN foto_profil VARCHAR(255) DEFAULT NULL AFTER minat";
    if (mysqli_query($conn, $alter_query)) {
        echo "Successfully added foto_profil column!\n";
    } else {
        echo "Error: " . mysqli_error($conn) . "\n";
    }
} else {
    echo "Column foto_profil already exists in mahasiswa table.\n";
}
?>
