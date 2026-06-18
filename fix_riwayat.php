<?php
$file = 'src/frontend/pages/learner/riwayat.php';
if (!file_exists($file)) {
    die("File not found\n");
}

$content = file_get_contents($file);

// Replace using regular expressions to match any non-ASCII characters (corrupted emojis) followed by optional spaces
$patterns = [
    '/[^\x00-\x7F]+\s*Selesai:/' => '<i class="bi bi-check-circle-fill"></i> Selesai:',
    '/[^\x00-\x7F]+\s*Dibatalkan:/' => '<i class="bi bi-x-circle-fill"></i> Dibatalkan:',
    '/[^\x00-\x7F]+\s*Waktu/' => '<i class="bi bi-clock"></i> Waktu',
    '/[^\x00-\x7F]+\s*Durasi/' => '<i class="bi bi-hourglass-split"></i> Durasi',
    '/[^\x00-\x7F]+\s*Catatan:/' => '<i class="bi bi-chat-left-text"></i> Catatan:',
    '/[^\x00-\x7F]+\s*Beri Review/' => '<i class="bi bi-star-fill"></i> Beri Review',
    // Match the corrupted star emojis inside labels for star ratings
    '/[^\x00-\x7F]+\s*<\/label>/' => '<i class="bi bi-star-fill"></i></label>'
];

$count = 0;
foreach ($patterns as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content, -1, $subcount);
    $count += $subcount;
}

if ($count > 0) {
    if (file_put_contents($file, $content)) {
        echo "Successfully updated $count items in $file using regex with spaces!\n";
    } else {
        echo "Error writing to $file\n";
    }
} else {
    echo "No matching patterns found in $file.\n";
}
?>
