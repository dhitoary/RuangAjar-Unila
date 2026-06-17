<?php
session_start();
header('Content-Type: application/json');
require_once '../../config/database.php';
require_once '../../config/midtrans_config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$booking_id = intval($data['booking_id'] ?? 0);

if ($booking_id <= 0) {
    echo json_encode(['error' => 'Invalid booking ID']);
    exit();
}

// Get booking details
$query = "SELECT b.*, s.subject_name, s.price, t.nama_lengkap as tutor_name, m.nama_lengkap as mahasiswa_name, m.email as mahasiswa_email
          FROM bookings b
          JOIN subjects s ON b.subject_id = s.id
          JOIN tutor t ON b.tutor_id = t.id
          JOIN mahasiswa m ON b.learner_id = m.id
          WHERE b.id = $booking_id";

$result = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    echo json_encode(['error' => 'Booking not found']);
    exit();
}

$order_id = 'RA-' . $booking_id . '-' . time();
$gross_amount = intval($booking['price']);

$params = [
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $gross_amount,
    ],
    'customer_details' => [
        'first_name' => $booking['mahasiswa_name'],
        'email' => $booking['mahasiswa_email'],
    ],
    'item_details' => [
        [
            'id' => 'TUTOR-' . $booking['tutor_id'],
            'price' => $gross_amount,
            'quantity' => 1,
            'name' => substr($booking['subject_name'] . ' - ' . $booking['tutor_name'], 0, 50),
        ]
    ],
];

// Call Midtrans Snap API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, MIDTRANS_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Basic ' . base64_encode(MIDTRANS_SERVER_KEY . ':'),
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$responseData = json_decode($response, true);

if ($httpCode == 201 && isset($responseData['token'])) {
    // Save snap token to booking
    $snap_token = mysqli_real_escape_string($conn, $responseData['token']);
    $order_id_escaped = mysqli_real_escape_string($conn, $order_id);
    mysqli_query($conn, "UPDATE bookings SET snap_token = '$snap_token', midtrans_order_id = '$order_id_escaped' WHERE id = $booking_id");
    
    echo json_encode([
        'snap_token' => $responseData['token'],
        'order_id' => $order_id,
    ]);
} else {
    echo json_encode(['error' => 'Failed to create transaction', 'details' => $responseData]);
}
?>
