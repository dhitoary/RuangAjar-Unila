<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

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

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Password Change
    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verify current password
        $check_query = "SELECT password FROM mahasiswa WHERE email = ?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "s", $user_email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        
        if (password_verify($current_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                if (strlen($new_password) >= 6) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_pwd_query = "UPDATE mahasiswa SET password = ? WHERE email = ?";
                    $stmt = mysqli_prepare($conn, $update_pwd_query);
                    mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $user_email);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = 'Password berhasil diubah!';
                    } else {
                        $error_message = 'Gagal mengubah password.';
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = 'Password baru minimal 6 karakter!';
                }
            } else {
                $error_message = 'Password baru dan konfirmasi tidak cocok!';
            }
        } else {
            $error_message = 'Password saat ini salah!';
        }
    } 
    // Handle Profile Update
    else {
        $nama_lengkap = $_POST['nama_lengkap'];
        $nim = $_POST['nim'];
        $jenjang = $_POST['jenjang'];
        $kelas = $_POST['kelas'];
        $sekolah = $_POST['sekolah'];
        $minat = $_POST['minat'];
        
        // Handle Photo Upload
        $foto_profil = $siswa_data['foto_profil'];
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if (in_array($_FILES['foto_profil']['type'], $allowed_types)) {
                if ($_FILES['foto_profil']['size'] <= $max_size) {
                    $upload_dir = '../../../uploads/profiles/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    $file_extension = pathinfo($_FILES['foto_profil']['name'], PATHINFO_EXTENSION);
                    $new_filename = 'profile_' . $user_id . '_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $upload_path)) {
                        // Delete old photo if exists
                        if ($siswa_data['foto_profil'] && file_exists('../../../' . $siswa_data['foto_profil'])) {
                            unlink('../../../' . $siswa_data['foto_profil']);
                        }
                        $foto_profil = 'uploads/profiles/' . $new_filename;
                    } else {
                        $error_message = 'Gagal upload foto profil.';
                    }
                } else {
                    $error_message = 'Ukuran foto maksimal 2MB!';
                }
            } else {
                $error_message = 'Format foto harus JPG, JPEG, PNG, atau GIF!';
            }
        }
        
        if (empty($error_message)) {
            $update_query = "UPDATE mahasiswa SET 
                nama_lengkap = ?,
                nim = ?,
                jenjang = ?,
                kelas = ?,
                sekolah = ?,
                minat = ?,
                foto_profil = ?
                WHERE email = ?";
            
            $stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt, "ssssssss", $nama_lengkap, $nim, $jenjang, $kelas, $sekolah, $minat, $foto_profil, $user_email);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = 'Profil berhasil diperbarui!';
                // Refresh data
                $stmt2 = mysqli_prepare($conn, "SELECT * FROM mahasiswa WHERE email = ? LIMIT 1");
                mysqli_stmt_bind_param($stmt2, "s", $user_email);
                mysqli_stmt_execute($stmt2);
                $siswa_result = mysqli_stmt_get_result($stmt2);
                $siswa_data = mysqli_fetch_assoc($siswa_result);
                mysqli_stmt_close($stmt2);
            } else {
                $error_message = 'Gagal memperbarui profil!';
            }
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - RuangAjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        

        

        

        .sb-brand .logo {
            width: 40px;
            height: 40px;
        }

        

        

        

        

        

        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 30px;
        }

        .profile-header {
            background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: white;
            color: #1a5276;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin: 0 auto 20px;
            border: 5px solid rgba(255,255,255,0.3);
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section h3 {
            color: #1a5276;
            font-size: 20px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2e86c1;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2e86c1;
            box-shadow: 0 0 0 3px rgba(154, 212, 214, 0.1);
        }

        .form-input:disabled {
            background: #f5f5f5;
            cursor: not-allowed;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #e0e0e0;
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

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- NAVBAR LEARNER -->
<?php include '../../layouts/header_learner.php'; ?>

<?php require_once '../../layouts/footer.php'; ?>





