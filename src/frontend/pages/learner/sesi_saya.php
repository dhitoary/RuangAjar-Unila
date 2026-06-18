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
    s.price,
    (SELECT COUNT(*) FROM reviews WHERE booking_id = b.id) as has_review
FROM bookings b
INNER JOIN tutor t ON b.tutor_id = t.id
INNER JOIN subjects s ON b.subject_id = s.id
$where_clause
ORDER BY b.booking_date DESC, b.booking_time DESC";

$bookings_result = mysqli_query($conn, $bookings_query);
?>

<?php
$assetPath = "../../assets/";
include '../../layouts/header.php';
?>

<style>
    .sessions-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }
    .sessions-header {
        margin-bottom: 35px;
    }
    .sessions-header h1 {
        color: #1a5276;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .sessions-header p {
        color: #64748b;
        font-size: 15px;
        margin: 0;
    }
    .tab-navigation {
        display: flex;
        gap: 12px;
        margin-bottom: 30px;
        border-bottom: 2px solid #e2e8f0;
        padding-bottom: 12px;
    }
    .tab-link {
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        font-size: 15px;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .tab-link:hover {
        color: #1a5276;
        background: #f8fafc;
    }
    .tab-link.active {
        background: #f1f5f9;
        color: #1a5276;
    }
    .session-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .session-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05), 0 4px 6px -2px rgba(0,0,0,0.05);
    }
    .session-info {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .tutor-avatar-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(26,82,118,0.15);
    }
    .tutor-img-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 4px 10px rgba(26,82,118,0.15);
    }
    .details h3 {
        margin: 0 0 6px 0;
        font-size: 18px;
        color: #1e293b;
        font-weight: 700;
    }
    .details .meta-group {
        margin-bottom: 8px;
    }
    .details .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #64748b;
        font-size: 14px;
        margin-right: 16px;
    }
    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .badge-pending {
        background: #fef3c7;
        color: #d97706;
    }
    .badge-confirmed {
        background: #dcfce7;
        color: #15803d;
    }
    .badge-completed {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .badge-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }
    .badge-paid {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #86efac;
    }
    .badge-unpaid {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fca5a5;
    }
    .session-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-end;
    }
    .btn-pay {
        background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-pay:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26,82,118,0.25);
    }
    .btn-review {
        background: white;
        color: #1a5276;
        border: 2px solid #1a5276;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-review:hover {
        background: #f0f7ff;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        border: 2px dashed #cbd5e1;
    }
    .empty-state i {
        font-size: 48px;
        color: #94a3b8;
        margin-bottom: 16px;
    }
    .empty-state p {
        color: #64748b;
        font-size: 16px;
        margin-bottom: 20px;
    }
    .btn-primary-link {
        display: inline-block;
        padding: 12px 30px;
        background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-primary-link:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(26,82,118,0.25);
    }
</style>

<div class="sessions-container">
    <div class="sessions-header">
        <h1>Sesi Saya</h1>
        <p>Kelola dan pantau seluruh sesi bimbingan belajar Anda</p>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <a href="sesi_saya.php?tab=semua" class="tab-link <?php echo $active_tab === 'semua' ? 'active' : ''; ?>">Semua</a>
        <a href="sesi_saya.php?tab=akan_datang" class="tab-link <?php echo $active_tab === 'akan_datang' ? 'active' : ''; ?>">Akan Datang</a>
        <a href="sesi_saya.php?tab=selesai" class="tab-link <?php echo $active_tab === 'selesai' ? 'active' : ''; ?>">Selesai</a>
        <a href="sesi_saya.php?tab=dibatalkan" class="tab-link <?php echo $active_tab === 'dibatalkan' ? 'active' : ''; ?>">Dibatalkan</a>
    </div>

    <!-- Sessions List -->
    <?php if (mysqli_num_rows($bookings_result) === 0): ?>
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <p>Tidak ada sesi bimbingan yang ditemukan untuk kategori ini.</p>
            <a href="../public/search_result.php" class="btn-primary-link">Cari Tutor Sekarang</a>
        </div>
    <?php else: ?>
        <?php while ($booking = mysqli_fetch_assoc($bookings_result)): 
            $initial = strtoupper(substr($booking['tutor_name'], 0, 2));
            $formatted_date = date('d M Y', strtotime($booking['booking_date']));
            $formatted_time = date('H:i', strtotime($booking['booking_time']));
        ?>
            <div class="session-card">
                <div class="session-info">
                    <?php if (!empty($booking['foto_profil'])): ?>
                        <img src="<?php echo $assetPath . 'img/' . htmlspecialchars($booking['foto_profil']); ?>" alt="Foto Tutor" class="tutor-img-circle">
                    <?php else: ?>
                        <div class="tutor-avatar-circle"><?php echo $initial; ?></div>
                    <?php endif; ?>
                    
                    <div class="details">
                        <h3><?php echo htmlspecialchars($booking['subject_name']); ?></h3>
                        <p style="margin: 0 0 8px 0; color: #1a5276; font-weight: 600; font-size: 15px;">
                            Tutor: <?php echo htmlspecialchars($booking['tutor_name']); ?>
                        </p>
                        <div class="meta-group">
                            <span class="meta-item">
                                <i class="bi bi-calendar3"></i> <?php echo $formatted_date; ?>
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-clock"></i> <?php echo $formatted_time; ?> WIB (<?php echo $booking['duration']; ?> mnt)
                            </span>
                            <span class="meta-item">
                                <i class="bi bi-wallet2"></i> Rp <?php echo number_format($booking['price'], 0, ',', '.'); ?>
                            </span>
                        </div>
                        <div>
                            <span class="badge badge-<?php echo $booking['status']; ?>">
                                <?php 
                                    if ($booking['status'] == 'pending') echo 'Menunggu';
                                    elseif ($booking['status'] == 'confirmed') echo 'Diterima';
                                    elseif ($booking['status'] == 'completed') echo 'Selesai';
                                    elseif ($booking['status'] == 'cancelled') echo 'Dibatalkan';
                                ?>
                            </span>
                            <span class="badge badge-<?php echo $booking['payment_status']; ?>" style="margin-left: 5px;">
                                <?php 
                                    if ($booking['payment_status'] == 'paid') echo 'Lunas';
                                    elseif ($booking['payment_status'] == 'pending') echo 'Pending';
                                    elseif ($booking['payment_status'] == 'unpaid') echo 'Belum Bayar';
                                    elseif ($booking['payment_status'] == 'failed') echo 'Gagal';
                                ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="session-actions">
                    <?php if ($booking['payment_status'] == 'unpaid' && $booking['status'] != 'cancelled'): ?>
                        <button onclick="payNow(<?php echo $booking['id']; ?>, '<?php echo $booking['snap_token']; ?>', this)" class="btn-pay" id="payBtn-<?php echo $booking['id']; ?>">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </button>
                    <?php elseif ($booking['status'] == 'completed' && $booking['has_review'] == 0): ?>
                        <button onclick="openReviewModal(<?php echo $booking['id']; ?>)" class="btn-review">
                            <i class="bi bi-chat-left-text"></i> Beri Ulasan
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</div>

<!-- Review Modal -->
<div class="review-modal" id="reviewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;">
    <div class="review-modal-content" style="background: white; padding: 40px; border-radius: 20px; max-width: 500px; width: 90%; position: relative;">
        <button onclick="closeReviewModal()" style="position: absolute; top: 15px; right: 15px; background: none; border: none; font-size: 30px; cursor: pointer; color: #999;">&times;</button>
        <div style="margin-bottom: 30px;">
            <h2 style="color: #1a5276; margin: 0 0 10px 0;">Beri Rating & Review</h2>
            <p style="color: #666; margin: 0;">Bagikan pengalaman belajar Anda</p>
        </div>
        <form id="reviewForm" action="../../../backend/learner/add_review.php" method="POST">
            <input type="hidden" name="booking_id" id="reviewBookingId">
            
            <div style="margin-bottom: 25px; text-align: center;">
                <div class="rating-input" style="display: flex; flex-direction: row-reverse; justify-content: center; gap: 10px;">
                    <input type="radio" name="rating" value="5" id="rating5" required style="display: none;">
                    <label for="rating5" style="font-size: 40px; cursor: pointer; transition: all 0.2s;" onclick="selectRating(5)">★</label>
                    <input type="radio" name="rating" value="4" id="rating4" style="display: none;">
                    <label for="rating4" style="font-size: 40px; cursor: pointer; transition: all 0.2s;" onclick="selectRating(4)">★</label>
                    <input type="radio" name="rating" value="3" id="rating3" style="display: none;">
                    <label for="rating3" style="font-size: 40px; cursor: pointer; transition: all 0.2s;" onclick="selectRating(3)">★</label>
                    <input type="radio" name="rating" value="2" id="rating2" style="display: none;">
                    <label for="rating2" style="font-size: 40px; cursor: pointer; transition: all 0.2s;" onclick="selectRating(2)">★</label>
                    <input type="radio" name="rating" value="1" id="rating1" style="display: none;">
                    <label for="rating1" style="font-size: 40px; cursor: pointer; transition: all 0.2s;" onclick="selectRating(1)">★</label>
                </div>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; color: #333; margin-bottom: 8px;">Review / Ulasan</label>
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

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-Rr8SHccGS2EF86NA"></script>
<script>
function selectRating(rating) {
    document.getElementById('rating' + rating).checked = true;
    for (let i = 1; i <= 5; i++) {
        const label = document.querySelector(`label[for="rating${i}"]`);
        if (i <= rating) {
            label.style.color = '#f39c12';
        } else {
            label.style.color = '#ddd';
        }
    }
}

function openReviewModal(bookingId) {
    document.getElementById('reviewBookingId').value = bookingId;
    document.getElementById('reviewModal').style.display = 'flex';
}

function closeReviewModal() {
    document.getElementById('reviewModal').style.display = 'none';
}

function payNow(bookingId, snapToken, btn) {
    btn.disabled = true;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

    // If we already have a snap token, trigger Snap Pay immediately
    if (snapToken && snapToken.trim() !== '') {
        triggerSnapPay(snapToken, btn, originalText);
    } else {
        // Otherwise, request a new snap token from the backend
        fetch('../../../backend/learner/create_transaction.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ booking_id: bookingId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.snap_token) {
                triggerSnapPay(data.snap_token, btn, originalText);
            } else {
                throw new Error(data.error || 'Gagal memproses transaksi.');
            }
        })
        .catch(err => {
            alert(err.message);
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }
}

function triggerSnapPay(token, btn, originalText) {
    window.snap.pay(token, {
        onSuccess: function() {
            window.location.href = 'sesi_saya.php?status=payment_success';
        },
        onPending: function() {
            window.location.href = 'sesi_saya.php?status=payment_pending';
        },
        onError: function() {
            alert('Pembayaran gagal. Silakan coba lagi.');
            btn.disabled = false;
            btn.innerHTML = originalText;
        },
        onClose: function() {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    });
}

document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>

<?php require_once '../../layouts/footer.php'; ?>
