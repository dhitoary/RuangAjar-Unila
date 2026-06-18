<?php
require_once 'src/config/database.php';
$tables = ['users', 'mahasiswa', 'tutor', 'reviews', 'tutor_mapel'];
foreach ($tables as $table) {
    $result = mysqli_query($conn, "SHOW CREATE TABLE $table");
    if ($result) {
        $row = mysqli_fetch_row($result);
        echo $row[1] . "\n\n";
    }
}
