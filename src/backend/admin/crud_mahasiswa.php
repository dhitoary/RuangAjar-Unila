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
        createSiswa($conn);
        break;
    case 'update':
        updateSiswa($conn);
        break;
    case 'delete':
        deleteSiswa($conn);
        break;
    case 'read':
        readSiswa($conn);
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

function createSiswa($conn) {
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $jenjang = $_POST['jenjang'];
    $sekolah = $_POST['sekolah'];
    $kelas = $_POST['kelas'];
    $minat = $_POST['minat'];
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
        $user_query = "INSERT INTO users (nama_lengkap, email, password, role) VALUES (?, ?, ?, 'learner')";
        $stmt_user = mysqli_prepare($conn, $user_query);
        mysqli_stmt_bind_param($stmt_user, "sss", $nama, $email, $default_password);
        if (!mysqli_stmt_execute($stmt_user)) {
            throw new Exception("Gagal membuat user login");
        }
        $user_id = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt_user);
        
        // Generate NIM
        $nim = 'SIS' . date('Y') . str_pad($user_id, 4, '0', STR_PAD_LEFT);
        
        // Insert into mahasiswa table
        $query = "INSERT INTO mahasiswa (nim, nama_lengkap, email, jenjang, sekolah, kelas, minat, status, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssssss", $nim, $nama, $email, $jenjang, $sekolah, $kelas, $minat, $status);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal menambahkan data mahasiswa");
        }
        mysqli_stmt_close($stmt);
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Mahasiswa berhasil ditambahkan (Password default: RuangAjar123)']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function updateSiswa($conn) {
    $id = intval($_POST['id']);
    $nama = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $jenjang = $_POST['jenjang'];
    $sekolah = $_POST['sekolah'];
    $kelas = $_POST['kelas'];
    $minat = $_POST['minat'];
    $status = $_POST['status'];
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Email tidak valid']);
        return;
    }
    
    // Ambil email lama
    $oldQuery = "SELECT email FROM mahasiswa WHERE id = ?";
    $stmt_old = mysqli_prepare($conn, $oldQuery);
    mysqli_stmt_bind_param($stmt_old, "i", $id);
    mysqli_stmt_execute($stmt_old);
    $res_old = mysqli_stmt_get_result($stmt_old);
    $row_old = mysqli_fetch_assoc($res_old);
    mysqli_stmt_close($stmt_old);
    
    if (!$row_old) {
        echo json_encode(['success' => false, 'message' => 'Mahasiswa tidak ditemukan']);
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
        
        // Update mahasiswa table
        $query = "UPDATE mahasiswa SET 
                  nama_lengkap = ?,
                  email = ?,
                  jenjang = ?,
                  sekolah = ?,
                  kelas = ?,
                  minat = ?,
                  status = ?
                  WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssssssi", $nama, $email, $jenjang, $sekolah, $kelas, $minat, $status, $id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal mengupdate data mahasiswa");
        }
        mysqli_stmt_close($stmt);
        
        mysqli_commit($conn);
        echo json_encode(['success' => true, 'message' => 'Data mahasiswa berhasil diupdate']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function deleteSiswa($conn) {
    $id = intval($_POST['id']);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
        return;
    }
    
    // Cek apakah mahasiswa memiliki booking aktif
    $checkBooking = "SELECT COUNT(*) as total FROM bookings WHERE learner_id = ? AND status IN ('pending', 'confirmed')";
    $stmt = mysqli_prepare($conn, $checkBooking);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if ($row['total'] > 0) {
        echo json_encode(['success' => false, 'message' => 'Tidak dapat menghapus mahasiswa yang memiliki booking aktif']);
        return;
    }
    
    // Ambil email mahasiswa
    $emailQuery = "SELECT email FROM mahasiswa WHERE id = ?";
    $stmt_email = mysqli_prepare($conn, $emailQuery);
    mysqli_stmt_bind_param($stmt_email, "i", $id);
    mysqli_stmt_execute($stmt_email);
    $res_email = mysqli_stmt_get_result($stmt_email);
    $row_email = mysqli_fetch_assoc($res_email);
    mysqli_stmt_close($stmt_email);
    
    if (!$row_email) {
        echo json_encode(['success' => false, 'message' => 'Mahasiswa tidak ditemukan']);
        return;
    }
    $email = $row_email['email'];
    
    mysqli_begin_transaction($conn);
    try {
        // Hapus dari mahasiswa
        $query = "DELETE FROM mahasiswa WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal menghapus data mahasiswa");
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
        echo json_encode(['success' => true, 'message' => 'Mahasiswa berhasil dihapus']);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

function readSiswa($conn) {
    $id = intval($_GET['id']);
    
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
        return;
    }
    
    $query = "SELECT * FROM mahasiswa WHERE id = ?";
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
