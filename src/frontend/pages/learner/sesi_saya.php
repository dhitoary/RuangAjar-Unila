<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

$siswa_query = "SELECT * FROM mahasiswa WHERE email = '$user_email' LIMIT 1";
$siswa_result = mysqli_query($conn, $siswa_query);
$siswa_data = mysqli_fetch_assoc($siswa_result);

if (!$siswa_data) {
    header("Location: ../auth/login.php");
    exit();
}

$siswa_id = $siswa_data['id'];

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'semua';

$where_clause = "WHERE b.learner_id = '$siswa_id'";
if ($active_tab == 'akan_datang') {
    $where_clause .= " AND b.status IN ('pending', 'confirmed') AND b.booking_date >= CURDATE()";
} elseif ($active_tab == 'selesai') {
    $where_clause .= " AND b.status = 'completed'";
} elseif ($active_tab == 'dibatalkan') {
    $where_clause .= " AND b.status = 'cancelled'";
}

$bookings_query = "SELECT 
    b.*,
    t.nama_lengkap as tutor_name,
    t.keahlian,
    t.foto_profil,
    s.subject_name,
    s.price
FROM bookings b
INNER JOIN tutor t ON b.tutor_id = t.id
INNER JOIN subjects s ON b.subject_id = s.id
$where_clause
ORDER BY b.booking_date DESC, b.booking_time DESC";

$bookings_result = mysqli_query($conn, $bookings_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Belajar Saya - RuangAjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<!-- NAVBAR LEARNER -->
<?php include '../../layouts/header_learner.php'; ?>

<!-- Review Modal -->
<div class="review-modal" id="reviewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
    <div class="review-modal-content" style="background: white; padding: 40px; border-radius: 20px; max-width: 500px; width: 90%; position: relative;">
        <button onclick="closeReviewModal()" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 30px; cursor: pointer; color: #999;">&times;</button>
        <div style="margin-bottom: 30px;">
            <h2 style="color: #1a5276; margin: 0 0 10px 0;">Beri Rating & Review</h2>
            <p style="color: #666; margin: 0;">Bagikan pengalaman belajar Anda</p>
        </div>
        <form id="reviewForm" action="../../../backend/learner/submit_review.php" method="POST">
            <input type="hidden" name="booking_id" id="reviewBookingId">
            
            <div style="margin-bottom: 25px; text-align: center;">
                <div class="rating-input" style="display: flex; flex-direction: row-reverse; justify-content: center; gap: 10px;">
                    <input type="radio" name="rating" value="5" id="rating5" required style="display: none;">
                    <label for="rating5" style="font-size: 40px; cursor: pointer; transition: all 0.3s;" onclick="selectRating(5)">â­</label>
                    <input type="radio" name="rating" value="4" id="rating4" style="display: none;">
                    <label for="rating4" style="font-size: 40px; cursor: pointer; transition: all 0.3s;" onclick="selectRating(4)">â­</label>
                    <input type="radio" name="rating" value="3" id="rating3" style="display: none;">
                    <label for="rating3" style="font-size: 40px; cursor: pointer; transition: all 0.3s;" onclick="selectRating(3)">â­</label>
                    <input type="radio" name="rating" value="2" id="rating2" style="display: none;">
                    <label for="rating2" style="font-size: 40px; cursor: pointer; transition: all 0.3s;" onclick="selectRating(2)">â­</label>
                    <input type="radio" name="rating" value="1" id="rating1" style="display: none;">
                    <label for="rating1" style="font-size: 40px; cursor: pointer; transition: all 0.3s;" onclick="selectRating(1)">â­</label>
                </div>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #333; margin-bottom: 8px;">Review</label>
                <textarea name="review_text" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; font-family: inherit;" rows="5" 
                          placeholder="Tuliskan pengalaman belajar Anda dengan tutor ini..." required></textarea>
            </div>
            
            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <button type="button" onclick="closeReviewModal()" style="padding: 12px 30px; background: #f0f0f0; color: #333; border: none; border-radius: 25px; cursor: pointer; font-weight: 600;">Batal</button>
                <button type="submit" style="padding: 12px 30px; background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%); color: white; border: none; border-radius: 25px; cursor: pointer; font-weight: 600;">Kirim Review</button>
            </div>
        </form>
    </div>
</div>

<script>
function selectRating(rating) {
    document.getElementById('rating' + rating).checked = true;
    // Highlight selected stars
    for (let i = 1; i <= 5; i++) {
        const label = document.querySelector(`label[for="rating${i}"]`);
        if (i <= rating) {
            label.style.filter = 'none';
            label.style.opacity = '1';
        } else {
            label.style.filter = 'grayscale(100%)';
            label.style.opacity = '0.3';
        }
    }
}

// Show/hide modal
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>

<?php require_once '../../layouts/footer.php'; ?>





