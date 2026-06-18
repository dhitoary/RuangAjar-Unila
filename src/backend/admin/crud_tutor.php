<?php
session_start();
require_once '../../config/database.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Ambil aksi dari request
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        createTutor($conn);
        break;
    case 'update':
        updateTutor($conn);
        break;
    case 'delete':
        deleteTutor($conn);
        break;
    case 'read':
        readTutor($conn);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function createTutor($conn) {
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $keahlian = $_POST['keahlian'];
    $pendidikan = $_POST['pendidikan'];
    $status = $_POST['status'] ?? 'Aktif';
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Email tidak valid']);
        return;
    }
    
    // Cek apakah email sudah ada di users
    $checkEmail = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $checkEmail);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        mysqli_stmt_close($stmt);
        echo json_encode(['success' => false, 'message' => 'Email sudah terdaftar']);
        return;
    }
    mysqli_stmt_close($stmt);
    
    mysqli_begin_transaction($conn);
    try {
        // Create user in users table
        $default_password = password_hash('RuangAjar123', PASSWORD_DEFAULT);
        $user_query = "INSERT INTO users (nama_lengkap, email, password, role) VALUES (?, ?, ?, 'tutor')";
        $stmt_user = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt_user, "sss", $nama, $email, $default_password);
        if (!mysqli_stmt_execute($stmt_user)) {
            throw new Exception("Gagal membuat user login");
        }
        mysqli_stmt_close($stmt_user);
        
        // Insert into tutor table
        $query = "INSERT INTO tutor (nama_lengkap, email, keahlian, pendidikan, status, telepon, pengalaman_mengajar, harga_per_sesi, deskripsi, rating, created_at) 
                  VALUES (?, ?, ?, ?, ?, '-', 0, 50000, 'Tutor didaftarkan oleh admin', 5.0, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $email, $keahlian, $pendidikan, $status);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal menambahkan data tutor");
        }
        mysqli_stmt_close($stmt);
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Tutor berhasil ditambahkan (Password default: RuangAjar123)']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function updateTutor($conn) {
    $id = intval($_POST['id']);
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $keahlian = $_POST['keahlian'];
    $pendidikan = $_POST['pendidikan'];
    $status = $_POST['status'];
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Email tidak valid']);
        return;
    }
    
    // Ambil email lama
    $oldQuery = "SELECT email FROM tutor WHERE id = ?";
    $stmt_old = mysqli_prepare($conn, $oldQuery);
    mysqli_stmt_bind_param($stmt_old, "i", $id);
    mysqli_stmt_execute($stmt_old);
    $res_old = mysqli_stmt_get_result($stmt_old);
    $row_old = mysqli_fetch_assoc($res_old);
    mysqli_stmt_close($stmt_old);
    
    if (!$row_old) {
        echo json_encode(['success' => false, 'message' => 'Tutor tidak ditemukan']);
        return;
    }
    $old_email = $row_old['email'];
    
    // Cek apakah email baru sudah digunakan oleh user lain
    $checkEmail = "SELECT id FROM users WHERE email = ? AND email != ?";
    $stmt = mysqli_prepare($conn, $checkEmail);
    mysqli_stmt_bind_param($stmt, "ss", $email, $old_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        mysqli_stmt_close($stmt);
        echo json_encode(['success' => false, 'message' => 'Email sudah digunakan oleh user lain']);
        return;
    }
    mysqli_stmt_close($stmt);
    
    mysqli_begin_transaction($conn);
    try {
        // Update users table
        $user_query = "UPDATE users SET nama_lengkap = ?, email = ? WHERE email = ?";
        $stmt_user = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt_user, "sss", $nama, $email, $old_email);
        if (!mysqli_stmt_execute($stmt_user)) {
            throw new Exception("Gagal mengupdate user login");
        }
        mysqli_stmt_close($stmt_user);
        
        // Update tutor table
        $query = "UPDATE tutor SET 
                  nama_lengkap = ?,
                  email = ?,
                  keahlian = ?,
                  pendidikan = ?,
                  status = ?
                  WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $nama, $email, $keahlian, $pendidikan, $status, $id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal mengupdate data tutor");
        }
        mysqli_stmt_close($stmt);
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Data tutor berhasil diupdate']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function deleteTutor($conn) {
    $id = intval($_POST['id']);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
        return;
    }
    
    // Cek apakah tutor memiliki booking aktif
    $checkBooking = "SELECT COUNT(*) as total FROM bookings WHERE tutor_id = ? AND status IN ('pending', 'confirmed')";
    $stmt = mysqli_prepare($conn, $checkBooking);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if ($row['total'] > 0) {
        echo json_encode(['success' => false, 'message' => 'Tidak dapat menghapus tutor yang memiliki kelas aktif']);
        return;
    }
    
    // Ambil email tutor
    $emailQuery = "SELECT email FROM tutor WHERE id = ?";
    $stmt_email = mysqli_prepare($conn, $emailQuery);
    mysqli_stmt_bind_param($stmt_email, "i", $id);
    mysqli_stmt_execute($stmt_email);
    $res_email = mysqli_stmt_get_result($stmt_email);
    $row_email = mysqli_fetch_assoc($res_email);
    mysqli_stmt_close($stmt_email);
    
    if (!$row_email) {
        echo json_encode(['success' => false, 'message' => 'Tutor tidak ditemukan']);
        return;
    }
    $email = $row_email['email'];
    
    mysqli_begin_transaction($conn);
    try {
        // Hapus dari tutor
        $query = "DELETE FROM tutor WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal menghapus data tutor");
        }
        mysqli_stmt_close($stmt);
        
        // Hapus dari users
        $query_user = "DELETE FROM users WHERE email = ?";
        $stmt_user = mysqli_prepare($conn, $query_user);
        mysqli_stmt_bind_param($stmt_user, "s", $email);
        if (!mysqli_stmt_execute($stmt_user)) {
            throw new Exception("Gagal menghapus user login");
        }
        mysqli_stmt_close($stmt_user);
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Tutor berhasil dihapus']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function readTutor($conn) {
    $id = intval($_GET['id']);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
        return;
    }
    
    $query = "SELECT * FROM tutor WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        echo json_encode(['success' => true, 'data' => $row]);
    } else {
        mysqli_stmt_close($stmt);
        echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
    }
}
?>
