<?php
// Load local keys if exists
$keysFile = __DIR__ . '/midtrans_keys.php';
if (file_exists($keysFile)) {
    require_once $keysFile;
} else {
    // Fallback if file doesn't exist
    if (!defined('MIDTRANS_SERVER_KEY')) define('MIDTRANS_SERVER_KEY', '');
    if (!defined('MIDTRANS_CLIENT_KEY')) define('MIDTRANS_CLIENT_KEY', '');
    if (!defined('MIDTRANS_MERCHANT_ID')) define('MIDTRANS_MERCHANT_ID', '');
}

// Midtrans Sandbox Configuration
define('MIDTRANS_IS_PRODUCTION', false);
define('MIDTRANS_SNAP_URL', 'https://app.sandbox.midtrans.com/snap/snap.js');
define('MIDTRANS_API_URL', 'https://app.sandbox.midtrans.com/snap/v1/transactions');
?>
