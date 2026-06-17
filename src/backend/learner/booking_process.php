<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized']);
        exit();
    }
    header("Location: ../../frontend/pages/auth/login.php?error=unauthorized");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $tutor_id   = htmlspecialchars($_POST['tutor_id'] ?? '');
    $subject_id = htmlspecialchars($_POST['subject_id'] ?? '');
    $date       = htmlspecialchars($_POST['booking_date'] ?? '');
    $learner_id = htmlspecialchars($_POST['learner_id'] ?? '');
    $time       = htmlspecialchars($_POST['booking_time'] ?? '');
    $duration   = intval($_POST['duration'] ?? 60);
    $notes      = htmlspecialchars($_POST['notes'] ?? '');

    // Check if AJAX request
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    // Also check if fetch API (no X-Requested-With but Accept: application/json or content type)
    $acceptsJson = (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    $isAjax = $isAjax || $acceptsJson || (isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== false);
    // Simpler: if subject_id is present and we have all fields, treat as possibly AJAX
    $isAjax = true; // Always return JSON now since booking.php uses fetch

    if (empty($tutor_id) || empty($subject_id) || empty($date) || empty($time)) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Harap lengkapi semua field yang diperlukan']);
            exit();
        }
        header("Location: ../../frontend/pages/learner/dashboard_mahasiswa.php?error=empty_fields");
        exit();
    }

    // Validate date
    $date_obj = DateTime::createFromFormat('Y-m-d', $date);
    if (!$date_obj || $date_obj->format('Y-m-d') !== $date) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Format tanggal tidak valid']);
            exit();
        }
        header("Location: ../../frontend/pages/learner/booking.php?error=invalid_date&tutor_id=" . $tutor_id);
        exit();
    }
    
    $today = new DateTime();
    $today->setTime(0, 0, 0);
    if ($date_obj < $today) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Tanggal tidak boleh di masa lalu']);
            exit();
        }
        header("Location: ../../frontend/pages/learner/booking.php?error=past_date&tutor_id=" . $tutor_id);
        exit();
    }
    
    $tutor_id_escaped = mysqli_real_escape_string($conn, $tutor_id);
    $subject_id_escaped = mysqli_real_escape_string($conn, $subject_id);
    $date_escaped = mysqli_real_escape_string($conn, $date);
    $time_escaped = mysqli_real_escape_string($conn, $time);
    $notes_escaped = mysqli_real_escape_string($conn, $notes);
    $learner_id_escaped = mysqli_real_escape_string($conn, $learner_id);
    
    $query = "INSERT INTO bookings (learner_id, tutor_id, subject_id, booking_date, booking_time, duration, status, payment_status, notes) 
              VALUES ('$learner_id_escaped', '$tutor_id_escaped', '$subject_id_escaped', '$date_escaped', '$time_escaped', '$duration', 'pending', 'unpaid', '$notes_escaped')";
    
    if (mysqli_query($conn, $query)) {
        $booking_id = mysqli_insert_id($conn);
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['booking_id' => $booking_id, 'status' => 'success']);
            exit();
        }
        header("Location: ../../frontend/pages/learner/dashboard_mahasiswa.php?status=booking_success");
    } else {
        $error_msg = mysqli_error($conn);
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Database error: ' . $error_msg]);
            exit();
        }
        header("Location: ../../frontend/pages/learner/booking.php?error=db_error&tutor_id=" . $tutor_id);
    }
    exit();

} else {
    header("Location: ../../frontend/pages/learner/dashboard_mahasiswa.php");
    exit();
}
?>
