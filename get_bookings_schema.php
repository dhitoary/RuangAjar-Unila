<?php
require_once 'src/config/database.php';
$result = mysqli_query($conn, "SHOW CREATE TABLE bookings");
$row = mysqli_fetch_row($result);
echo $row[1] . "\n\n";
