<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : (isset($_SESSION['email']) ? $_SESSION['email'] : '');

$siswa_query = "SELECT * FROM mahasiswa WHERE email = '$user_email' LIMIT 1";
$siswa_result = mysqli_query($conn, $siswa_query);
$siswa_data = mysqli_fetch_assoc($siswa_result);

if (!$siswa_data) {
    header("Location: ../auth/login.php?error=no_student_data");
    exit();
}

$siswa_id = $siswa_data['id'];

// Query untuk riwayat booking yang sudah selesai atau dibatalkan
$riwayat_query = "SELECT 
    b.*,
    t.nama_lengkap as tutor_name,
    t.keahlian,
    t.foto_profil,
    s.subject_name,
    s.price,
    r.id as review_id,
    r.rating as review_rating,
    r.review_text as review_text
FROM bookings b
INNER JOIN tutor t ON b.tutor_id = t.id
INNER JOIN subjects s ON b.subject_id = s.id
LEFT JOIN reviews r ON r.booking_id = b.id
WHERE b.learner_id = '$siswa_id' AND b.status IN ('completed', 'cancelled')
ORDER BY b.booking_date DESC, b.created_at DESC";

$riwayat_result = mysqli_query($conn, $riwayat_query);

// Count statistik
$count_completed_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE learner_id = '$siswa_id' AND status = 'completed'");
$count_completed = $count_completed_result ? mysqli_fetch_assoc($count_completed_result)['total'] : 0;

$count_cancelled_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE learner_id = '$siswa_id' AND status = 'cancelled'");
$count_cancelled = $count_cancelled_result ? mysqli_fetch_assoc($count_cancelled_result)['total'] : 0;


$logoPath = "../../../assets/img/logo.png";
?>

<?php
$assetPath = "../../assets/";
include '../../layouts/header.php';
?>

<div style="padding-top: 20px;">

<style>
.riwayat-container {
    padding: 40px 0;
}

.riwayat-header {
    margin-bottom: 35px;
}

.riwayat-header h1 {
    color: var(--primary);
    font-weight: 800;
    font-size: 2.2rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.riwayat-header p {
    color: var(--muted);
    font-size: 1.05rem;
    margin: 0;
}

/* Stats Summary Cards */
.stats-summary {
    display: flex;
    gap: 20px;
    margin-top: 25px;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 16px;
    background: white;
    padding: 18px 24px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    flex: 1;
    min-width: 200px;
    transition: transform 0.2s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
}

.stat-item i {
    font-size: 32px;
}

.stat-completed i {
    color: var(--success);
}

.stat-cancelled i {
    color: var(--danger);
}

.stat-label {
    display: block;
    font-size: 13px;
    color: var(--muted);
    font-weight: 500;
    margin-bottom: 2px;
}

.stat-count {
    font-size: 20px;
    font-weight: 800;
    color: var(--dark);
}

/* Filter Tabs */
.filter-tabs {
    display: flex;
    gap: 12px;
    margin: 35px 0 25px 0;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 10px 24px;
    background: white;
    border: 1px solid var(--border);
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 600;
    color: var(--muted);
    font-size: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}

.filter-tab:hover {
    border-color: var(--primary-light);
    color: var(--primary-light);
    background: var(--primary-soft);
}

.filter-tab.active {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(26,82,118,0.2);
}

/* Booking Cards */
.bookings-list {
    display: grid;
    gap: 20px;
}

.booking-card {
    background: white;
    padding: 28px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    border-left: 6px solid var(--primary);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.booking-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(26,82,118,0.12);
}

.booking-card[data-status="cancelled"] {
    border-left-color: var(--danger);
}

.booking-card[data-status="completed"] {
    border-left-color: var(--success);
}

.booking-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 15px;
}

.booking-tutor-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.tutor-avatar-img {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid var(--primary-soft);
    background: var(--primary-soft);
}

.tutor-avatar-small {
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: var(--primary-soft);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    border: 2.5px solid var(--primary-soft);
}

.booking-card[data-status="cancelled"] .tutor-avatar-small {
    background: #f8d7da;
    color: var(--danger);
    border-color: #f8d7da;
}

.booking-card[data-status="completed"] .tutor-avatar-small {
    background: #d4edda;
    color: var(--success);
    border-color: #d4edda;
}

.status-badge {
    padding: 6px 16px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    text-transform: capitalize;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.booking-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
}

.booking-details p {
    margin: 0;
    color: var(--muted);
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.booking-details strong {
    display: block;
    margin-top: 6px;
    font-size: 15px;
    color: var(--dark);
    font-weight: 600;
}

.booking-details .price-val {
    color: var(--primary);
    font-weight: 700;
}

.notes-container {
    margin-top: 20px;
    padding: 16px 20px;
    background: var(--bg);
    border-radius: var(--radius);
    border-left: 3px solid var(--muted);
}

.notes-title {
    margin: 0 0 6px 0;
    color: var(--muted);
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.notes-text {
    margin: 0;
    color: var(--dark);
    font-size: 14px;
    line-height: 1.5;
}

.booking-actions {
    margin-top: 25px;
    display: flex;
    gap: 12px;
    border-top: 1px solid var(--border);
    padding-top: 20px;
}

.btn-review {
    padding: 10px 22px;
    background: var(--accent);
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 700;
    font-size: 14px;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(243,156,18,0.25);
}

.btn-review:hover {
    background: var(--accent-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(243,156,18,0.35);
}

.btn-book-again {
    padding: 10px 22px;
    background: var(--primary-soft);
    color: var(--primary);
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 700;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: 1px solid transparent;
}

.btn-book-again:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26,82,118,0.15);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.empty-state-icon {
    font-size: 72px;
    color: var(--primary-soft);
    margin-bottom: 24px;
    display: inline-block;
    width: 120px;
    height: 120px;
    line-height: 120px;
    background: var(--bg);
    border-radius: 50%;
}

.empty-state h3 {
    margin: 0 0 10px 0;
    color: var(--dark);
    font-weight: 800;
    font-size: 1.4rem;
}

.empty-state p {
    color: var(--muted);
    font-size: 1rem;
    max-width: 400px;
    margin: 0 auto 30px;
}

.empty-state-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 30px;
    background: var(--primary);
    color: white !important;
    text-decoration: none;
    font-weight: 700;
    border-radius: 10px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(26,82,118,0.25);
}

.empty-state-btn:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(26,82,118,0.35);
}

/* Glassmorphic Review Modal */
.review-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(26, 82, 118, 0.4);
    backdrop-filter: blur(8px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.review-modal.active {
    display: flex;
}

.review-modal-content {
    background: white;
    padding: 40px;
    border-radius: var(--radius);
    max-width: 500px;
    width: 90%;
    position: relative;
    box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    border: 1px solid var(--border);
    animation: modalSlideIn 0.3s ease;
}

@keyframes modalSlideIn {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<div class="riwayat-container">
    <div class="container">
        <div class="riwayat-header">
            <h1><i class="bi bi-clock-history"></i> Riwayat Booking</h1>
            <p>Lihat semua sesi belajar yang telah selesai atau dibatalkan</p>
            
            <div class="stats-summary">
                <div class="stat-item stat-completed">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <span class="stat-label">Selesai</span>
                        <span class="stat-count"><?php echo $count_completed; ?> Sesi</span>
                    </div>
                </div>
                <div class="stat-item stat-cancelled">
                    <i class="bi bi-x-circle-fill"></i>
                    <div>
                        <span class="stat-label">Dibatalkan</span>
                        <span class="stat-count"><?php echo $count_cancelled; ?> Sesi</span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'review_success'): ?>
            <div class="alert alert-success">
                Review berhasil dikirim! Terima kasih atas feedback Anda.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php
                $error = $_GET['error'];
                if ($error == 'invalid_rating') echo "Rating harus antara 1-5.";
                elseif ($error == 'empty_review') echo "Harap isi review terlebih dahulu.";
                elseif ($error == 'invalid_booking') echo "Booking tidak valid atau tidak ditemukan.";
                elseif ($error == 'review_exists') echo "Anda sudah memberikan review untuk booking ini.";
                elseif ($error == 'db_error') echo "Terjadi kesalahan database.";
                else echo "Terjadi kesalahan. Silakan coba lagi.";
                ?>
            </div>
        <?php endif; ?>

        <div class="filter-tabs">
            <div class="filter-tab active" data-filter="all">Semua Riwayat</div>
            <div class="filter-tab" data-filter="completed">Selesai</div>
            <div class="filter-tab" data-filter="cancelled">Dibatalkan</div>
        </div>

        <div id="bookingsList" class="bookings-list">
            <?php if ($riwayat_result && mysqli_num_rows($riwayat_result) > 0): ?>
                <?php while ($booking = mysqli_fetch_assoc($riwayat_result)): 
                    $tutor_initial = strtoupper(substr($booking['tutor_name'], 0, 1));
                    $date = new DateTime($booking['booking_date']);
                    $date_formatted = $date->format('d M Y');
                    $time_formatted = date('H:i', strtotime($booking['booking_time']));
                    $price_formatted = 'Rp ' . number_format($booking['price'], 0, ',', '.');
                    
                    $status_class = $booking['status'];
                    $status_label = $booking['status'] == 'completed' ? 'Selesai' : 'Dibatalkan';
                ?>
                <div class="booking-card" data-status="<?php echo $booking['status']; ?>">
                    <div class="booking-card-header">
                        <div class="booking-tutor-info">
                            <?php if (!empty($booking['foto_profil'])): ?>
                                <img class="tutor-avatar-img" src="../../../<?php echo htmlspecialchars($booking['foto_profil']); ?>" alt="<?php echo htmlspecialchars($booking['tutor_name']); ?>">
                            <?php else: ?>
                                <div class="tutor-avatar-small"><?php echo $tutor_initial; ?></div>
                            <?php endif; ?>
                            <div>
                                <h3 style="margin: 0; color: var(--primary); font-weight: 700; font-size: 1.15rem;"><?php echo htmlspecialchars($booking['tutor_name']); ?></h3>
                                <p style="margin: 4px 0 0 0; color: var(--muted); font-size: 0.85rem;"><?php echo htmlspecialchars($booking['subject_name']); ?></p>
                            </div>
                        </div>
                        <span class="status-badge status-<?php echo $booking['status']; ?>">
                            <i class="bi <?php echo $booking['status'] == 'completed' ? 'bi-check-circle-fill' : 'bi-x-circle-fill'; ?>"></i>
                            <?php echo $status_label; ?>
                        </span>
                    </div>
                    <div class="booking-details">
                        <div>
                            <p><i class="bi bi-calendar"></i> Tanggal</p>
                            <strong><?php echo $date_formatted; ?></strong>
                        </div>
                        <div>
                            <p><i class="bi bi-clock"></i> Waktu</p>
                            <strong><?php echo $time_formatted; ?> WIB</strong>
                        </div>
                        <div>
                            <p><i class="bi bi-hourglass-split"></i> Durasi</p>
                            <strong><?php echo $booking['duration']; ?> menit</strong>
                        </div>
                        <div>
                            <p><i class="bi bi-cash"></i> Harga</p>
                            <strong class="price-val"><?php echo $price_formatted; ?></strong>
                        </div>
                    </div>
                    <?php if ($booking['notes']): ?>
                    <div class="notes-container">
                        <p class="notes-title"><i class="bi bi-chat-left-text"></i> Catatan:</p>
                        <p class="notes-text"><?php echo htmlspecialchars($booking['notes']); ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if ($booking['status'] == 'completed'): ?>
                    <div class="booking-actions">
                        <?php if (empty($booking['review_id'])): ?>
                            <button class="btn-review" onclick="openReviewModal(<?php echo $booking['id']; ?>)">
                                <i class="bi bi-star-fill"></i> Beri Review
                            </button>
                        <?php else: ?>
                            <!-- Review sudah ada, tampilkan isinya -->
                            <div style="background: #fdf6e3; border: 1px solid #f39c12; border-radius: 10px; padding: 10px 15px; text-align: left; margin-right: 15px; display: inline-block;">
                                <div style="margin-bottom: 4px;">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span style="color: <?php echo $i <= $booking['review_rating'] ? '#f39c12' : '#ddd'; ?>; font-size: 14px;">★</span>
                                    <?php endfor; ?>
                                </div>
                                <p style="margin: 0; color: #555; font-size: 12px; line-height: 1.4; word-break: break-word; font-style: italic;">
                                    "<?php echo htmlspecialchars(mb_strimwidth($booking['review_text'], 0, 80, '...')); ?>"
                                </p>
                            </div>
                        <?php endif; ?>
                        <a href="sesi_saya.php" class="btn-book-again">
                            <i class="bi bi-arrow-repeat"></i> Booking Lagi
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="bi bi-journal-x"></i></div>
                    <h3>Belum ada riwayat booking</h3>
                    <p>Riwayat booking yang sudah selesai atau dibatalkan akan muncul di sini</p>
                    <p style="margin-top: 20px;">
                        <a href="../public/search_result.php" class="empty-state-btn">
                            Cari Tutor Sekarang <i class="bi bi-arrow-right"></i>
                        </a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div class="review-modal" id="reviewModal">
    <div class="review-modal-content">
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
                    <label for="rating5" style="font-size: 40px; cursor: pointer; transition: all 0.3s; filter: grayscale(100%); opacity: 0.3;" onclick="selectRating(5)"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="rating" value="4" id="rating4" style="display: none;">
                    <label for="rating4" style="font-size: 40px; cursor: pointer; transition: all 0.3s; filter: grayscale(100%); opacity: 0.3;" onclick="selectRating(4)"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="rating" value="3" id="rating3" style="display: none;">
                    <label for="rating3" style="font-size: 40px; cursor: pointer; transition: all 0.3s; filter: grayscale(100%); opacity: 0.3;" onclick="selectRating(3)"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="rating" value="2" id="rating2" style="display: none;">
                    <label for="rating2" style="font-size: 40px; cursor: pointer; transition: all 0.3s; filter: grayscale(100%); opacity: 0.3;" onclick="selectRating(2)"><i class="bi bi-star-fill"></i></label>
                    <input type="radio" name="rating" value="1" id="rating1" style="display: none;">
                    <label for="rating1" style="font-size: 40px; cursor: pointer; transition: all 0.3s; filter: grayscale(100%); opacity: 0.3;" onclick="selectRating(1)"><i class="bi bi-star-fill"></i></label>
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
function openReviewModal(bookingId) {
    document.getElementById('reviewBookingId').value = bookingId;
    const modal = document.getElementById('reviewModal');
    modal.style.display = 'flex';
}

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.style.display = 'none';
    document.getElementById('reviewForm').reset();
    // Reset star ratings
    for (let i = 1; i <= 5; i++) {
        const label = document.querySelector(`label[for="rating${i}"]`);
        label.style.filter = 'grayscale(100%)';
        label.style.opacity = '0.3';
    }
}

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

// Filter bookings client-side
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const cards = document.querySelectorAll('.booking-card');
        
        cards.forEach(card => {
            if (filter === 'all' || card.dataset.status === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>

<?php require_once '../../layouts/footer.php'; ?>






