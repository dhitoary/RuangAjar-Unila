<?php
require_once '../../config/database.php';
require_once '../../config/midtrans_config.php';

$raw = file_get_contents('php://input');
$notification = json_decode($raw, true);

if (!$notification) {
    http_response_code(400);
    exit();
}

$order_id = $notification['order_id'] ?? '';
$status_code = $notification['status_code'] ?? '';
$gross_amount = $notification['gross_amount'] ?? '';
$signature_key = $notification['signature_key'] ?? '';
$transaction_status = $notification['transaction_status'] ?? '';
$fraud_status = $notification['fraud_status'] ?? '';

// Verify signature
$expected_signature = hash('sha512', $order_id . $status_code . $gross_amount . MIDTRANS_SERVER_KEY);

if ($signature_key !== $expected_signature) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid signature']);
    exit();
}

// Extract booking_id from order_id (format: RA-{booking_id}-{timestamp})
$parts = explode('-', $order_id);
$booking_id = intval($parts[1] ?? 0);

if ($booking_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid order ID']);
    exit();
}

$order_id_escaped = mysqli_real_escape_string($conn, $order_id);

if ($transaction_status == 'capture' || $transaction_status == 'settlement') {
    if ($fraud_status == 'accept' || empty($fraud_status)) {
        mysqli_query($conn, "UPDATE bookings SET payment_status = 'paid', status = 'confirmed' WHERE id = $booking_id AND midtrans_order_id = '$order_id_escaped'");
    }
} elseif ($transaction_status == 'pending') {
    mysqli_query($conn, "UPDATE bookings SET payment_status = 'pending' WHERE id = $booking_id AND midtrans_order_id = '$order_id_escaped'");
} elseif (in_array($transaction_status, ['deny', 'cancel', 'expire'])) {
    mysqli_query($conn, "UPDATE bookings SET payment_status = 'failed', status = 'cancelled' WHERE id = $booking_id AND midtrans_order_id = '$order_id_escaped'");
}

http_response_code(200);
echo json_encode(['status' => 'ok']);
?>
