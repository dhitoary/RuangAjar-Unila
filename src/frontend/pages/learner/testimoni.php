<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

// Get mahasiswa data
$siswa_query = "SELECT * FROM mahasiswa WHERE email = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $siswa_query);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$siswa_result = mysqli_stmt_get_result($stmt);
$siswa_data = mysqli_fetch_assoc($siswa_result);
mysqli_stmt_close($stmt);

if (!$siswa_data) {
    header("Location: ../auth/login.php");
    exit();
}

$learner_id = $siswa_data['id'];

// Get completed bookings without review
$bookings_query = "SELECT b.*, t.nama_lengkap as tutor_nama, s.subject_name,
                   (SELECT COUNT(*) FROM reviews WHERE booking_id = b.id) as has_review
                   FROM bookings b
                   JOIN tutor t ON b.tutor_id = t.id
                   JOIN subjects s ON b.subject_id = s.id
                   WHERE b.learner_id = ? AND b.status = 'completed'
                   ORDER BY b.booking_date DESC";
$stmt = mysqli_prepare($conn, $bookings_query);
mysqli_stmt_bind_param($stmt, "i", $learner_id);
mysqli_stmt_execute($stmt);
$bookings_result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

// Get my reviews
$reviews_query = "SELECT r.*, t.nama_lengkap as tutor_nama, s.subject_name, b.booking_date
                  FROM reviews r
                  JOIN tutor t ON r.tutor_id = t.id
                  JOIN bookings b ON r.booking_id = b.id
                  JOIN subjects s ON b.subject_id = s.id
                  WHERE r.learner_id = ?
                  ORDER BY r.created_at DESC";
$stmt = mysqli_prepare($conn, $reviews_query);
mysqli_stmt_bind_param($stmt, "i", $learner_id);
mysqli_stmt_execute($stmt);
$reviews_result = mysqli_stmt_get_result($stmt);
mysqli_stmt_close($stmt);

$success_message = '';
$error_message = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'review_success') {
        $success_message = 'Testimoni berhasil ditambahkan!';
    }
}

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'invalid_rating') {
        $error_message = 'Rating harus antara 1-5!';
    } elseif ($_GET['error'] == 'empty_review') {
        $error_message = 'Testimoni tidak boleh kosong!';
    } elseif ($_GET['error'] == 'invalid_booking') {
        $error_message = 'Booking tidak valid atau belum selesai!';
    } elseif ($_GET['error'] == 'review_exists') {
        $error_message = 'Anda sudah memberikan testimoni untuk sesi ini!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni - RuangAjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        

        

        

        .sb-brand .logo {
            width: 40px;
            height: 40px;
        }

        

        

        

        

        

        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 30px;
        }

        .page-header {
            background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .tab-btn {
            padding: 12px 30px;
            border: none;
            background: white;
            color: #666;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .booking-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .tutor-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .tutor-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
        }

        .rating-stars {
            display: flex;
            gap: 5px;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .star {
            color: #ddd;
            cursor: pointer;
            transition: all 0.2s;
        }

        .star.active,
        .star:hover {
            color: #f39c12;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2e86c1;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .review-item {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .review-rating {
            color: #f39c12;
            font-size: 18px;
        }

        .review-date {
            color: #999;
            font-size: 12px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 80px;
            margin-bottom: 20px;
            color: #ddd;
        }
    </style>
</head>
<body>

<!-- NAVBAR LEARNER -->
<?php include '../../layouts/header_learner.php'; ?>

<?php require_once '../../layouts/footer.php'; ?>





