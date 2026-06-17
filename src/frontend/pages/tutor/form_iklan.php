<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'tutor') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

$tutor_query = "SELECT * FROM tutor WHERE email = '$user_email' LIMIT 1";
$tutor_result = mysqli_query($conn, $tutor_query);
$tutor_data = mysqli_fetch_assoc($tutor_result);

$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Iklan Tutor - RuangAjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    :root {
        --primary-color: #1a5276;
        --primary-dark: #E55A2B;
        --secondary-color: #1B4965;
        --accent-color: #9FD3C7;
        --success-color: #48bb78;
        --warning-color: #1a5276;
        --danger-color: #f56565;
        --dark-color: #0A1628;
        --light-bg: #f5f5f5;
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        --hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
        --border-radius-lg: 1rem;
        --border-radius-md: 0.75rem;
    }

    body {
        background: var(--light-bg);
        font-family: 'Poppins', sans-serif;
    }

    .card-custom {
        background: white;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--card-shadow);
        padding: 30px;
        transition: 0.3s ease;
    }

    .card-custom:hover {
        box-shadow: var(--hover-shadow);
    }

    .btn-primary {
        background: var(--primary-color) !important;
        border: none;
        border-radius: var(--border-radius-md);
    }

    .btn-primary:hover {
        background: var(--primary-dark) !important;
    }

    label {
        font-weight: 600;
        color: var(--secondary-color);
    }

    .form-control,
    .form-select {
        border-radius: var(--border-radius-md);
        padding: 10px 14px;
    }

    .page-title {
        font-size: 26px;
        font-weight: 700;
        color: var(--secondary-color);
        margin-bottom: 20px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: var(--border-radius-md);
        margin-bottom: 20px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Navbar styles */
    .sb-navbar {
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 100;
        margin-bottom: 20px;
    }

    .sb-nav-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sb-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 700;
        color: #1a5276;
        text-decoration: none;
    }

    .sb-brand .logo {
        width: 40px;
        height: 40px;
    }

    .btn-back {
        background: var(--secondary-color);
        color: white;
        padding: 10px 20px;
        border-radius: var(--border-radius-md);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back:hover {
        background: #1a5276;
        color: white;
    }
</style>

</head>

<body>

<!-- NAVBAR TUTOR -->
<?php include '../../layouts/header_tutor.php'; ?>
</body>
</html>




