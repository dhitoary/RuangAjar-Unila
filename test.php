<?php
$subjects = [
    ['nama_mapel' => 'Math', 'jenjang' => 'SMA'],
    ['nama_mapel' => 'Physics', 'jenjang' => 'SMA']
];
$prices = array_column($subjects, 'price');
var_dump($prices);
if (empty($prices)) {
    echo "Empty!\n";
}
