<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'tutor') {
    header("Location: ../../frontend/pages/auth/login.php?error=unauthorized");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../../frontend/pages/tutor/mata_pelajaran.php?error=invalid_method");
    exit();
}

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

// Get tutor ID
$tutor_query = "SELECT id FROM tutor WHERE email = '$user_email' LIMIT 1";
$tutor_result = mysqli_query($conn, $tutor_query);
$tutor_data = mysqli_fetch_assoc($tutor_result);
$tutor_id = $tutor_data['id'];

$subject_id = intval($_POST['id']);
$subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$price = intval($_POST['price']);

// Verify subject belongs to this tutor
$check_query = "SELECT id FROM subjects WHERE id = '$subject_id' AND tutor_id = '$tutor_id'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) == 0) {
    header("Location: ../../frontend/pages/tutor/mata_pelajaran.php?error=unauthorized_subject");
    exit();
}

$update_query = "UPDATE subjects SET 
                 subject_name = '$subject_name', 
                 description = '$description', 
                 price = '$price' 
                 WHERE id = '$subject_id' AND tutor_id = '$tutor_id'";

if (mysqli_query($conn, $update_query)) {
    header("Location: ../../frontend/pages/tutor/mata_pelajaran.php?success=updated");
} else {
    header("Location: ../../frontend/pages/tutor/mata_pelajaran.php?error=" . urlencode(mysqli_error($conn)));
}

exit();
?>
