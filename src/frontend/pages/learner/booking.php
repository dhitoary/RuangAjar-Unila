<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'learner') {
    header("Location: ../auth/login.php?error=unauthorized");
    exit();
}

$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : $_SESSION['email'];

$siswa_query = "SELECT * FROM mahasiswa WHERE email = '$user_email' LIMIT 1";
$siswa_result = mysqli_query($conn, $siswa_query);
$siswa_data = mysqli_fetch_assoc($siswa_result);

if (!$siswa_data) {
    header("Location: ../auth/login.php");
    exit();
}

$siswa_id = $siswa_data['id'];
$tutor_id = isset($_GET['tutor_id']) ? intval($_GET['tutor_id']) : 0;
$subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;

$tutor_data = null;
$subjects_list = [];

if ($tutor_id > 0) {
    $tutor_query = "SELECT * FROM tutor WHERE id = '$tutor_id' AND status = 'Aktif' LIMIT 1";
    $tutor_result = mysqli_query($conn, $tutor_query);
    if ($tutor_result && mysqli_num_rows($tutor_result) > 0) {
        $tutor_data = mysqli_fetch_assoc($tutor_result);
        
        $subjects_query = "SELECT * FROM subjects WHERE tutor_id = '$tutor_id'";
        $subjects_result = mysqli_query($conn, $subjects_query);
        while ($row = mysqli_fetch_assoc($subjects_result)) {
            $subjects_list[] = $row;
        }
    }
}
?>

<?php
$assetPath = "../../assets/";
include '../../layouts/header.php';
?>


<style>
.booking-container {
    padding: 50px 30px;
    max-width: 800px;
    margin: 0 auto;
}

.booking-header {
    text-align: center;
    margin-bottom: 30px;
}

.booking-header h1 {
    color: #1a5276;
    margin-bottom: 10px;
}

.step-indicator {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin: 30px 0;
    position: relative;
}

.step-indicator::before {
    content: '';
    position: absolute;
    top: 20px;
    left: 25%;
    right: 25%;
    height: 2px;
    background: #ddd;
    z-index: 0;
}

.step {
    background: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ddd;
    position: relative;
    z-index: 1;
    font-weight: bold;
    color: #999;
}

.step.active {
    background: #1a5276;
    color: white;
    border-color: #1a5276;
}

.step.completed {
    background: #28A745;
    color: white;
    border-color: #28A745;
}

.step-content {
    display: none;
}

.step-content.active {
    display: block;
}

.booking-card {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.tutor-info {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 25px;
}

.tutor-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a5276, #2e86c1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.subject-select {
    margin-bottom: 20px;
}

.subject-option {
    padding: 20px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    margin-bottom: 15px;
    cursor: pointer;
    transition: all 0.3s;
}

.subject-option:hover {
    border-color: #2e86c1;
    background: #f0f9ff;
}

.subject-option.selected {
    border-color: #1a5276;
    background: #fff5f0;
}

.subject-option input[type="radio"] {
    margin-right: 10px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
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
    box-shadow: 0 0 0 3px rgba(154, 212, 214, 0.1);
}

.confirmation-details {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.confirmation-details p {
    margin: 12px 0;
    display: flex;
    justify-content: space-between;
    font-size: 15px;
}

.confirmation-details strong {
    color: #1a5276;
}

.btn-group {
    display: flex;
    gap: 15px;
    justify-content: space-between;
    margin-top: 30px;
}

.btn-secondary {
    padding: 12px 30px;
    background: #f0f0f0;
    color: #333;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    font-weight: 600;
}

.btn-secondary:hover {
    background: #e0e0e0;
}

.btn-primary {
    padding: 12px 30px;
    background: linear-gradient(135deg, #1a5276 0%, #2e86c1 100%);
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
}

.alert {
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>

<div class="booking-container">
    <div class="booking-header">
        <h1>Booking Tutor</h1>
        <p>Isi form berikut untuk memesan sesi belajar</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php
            $error = $_GET['error'];
            if ($error == 'empty_fields') echo "Harap lengkapi semua field yang diperlukan.";
            elseif ($error == 'invalid_date') echo "Format tanggal tidak valid.";
            elseif ($error == 'past_date') echo "Tanggal tidak boleh di masa lalu.";
            elseif ($error == 'db_error') echo "Terjadi kesalahan database. Silakan coba lagi.";
            else echo "Terjadi kesalahan. Silakan coba lagi.";
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
            <i class="bi bi-check-circle-fill"></i> Booking berhasil! Silakan cek halaman <a href="sesi_saya.php">Sesi Saya</a>.
        </div>
    <?php endif; ?>

    <?php if (!$tutor_data): ?>
        <div class="alert alert-error">
            Tutor tidak ditemukan. <a href="../public/search_result.php">Kembali ke pencarian</a>
        </div>
    <?php else: ?>
        <form id="bookingForm" action="../../../backend/learner/booking_process.php" method="POST">
            <input type="hidden" name="tutor_id" value="<?php echo $tutor_data['id']; ?>">
            <input type="hidden" name="learner_id" value="<?php echo $siswa_id; ?>">
            <input type="hidden" name="duration" value="90">
            
            <div class="step-content active" id="step1">
                <div class="booking-card">
                    <h2 style="margin-bottom: 20px; color: #1a5276;">Pilih Mata Kuliah</h2>
                    
                    <div class="tutor-info">
                        <div class="tutor-avatar">
                            <?php echo strtoupper(substr($tutor_data['nama_lengkap'], 0, 1)); ?>
                        </div>
                        <div>
                            <strong style="font-size: 18px;"><?php echo htmlspecialchars($tutor_data['nama_lengkap']); ?></strong>
                            <p style="font-size: 14px; color: #666; margin: 5px 0 0 0;">
                                <?php echo htmlspecialchars($tutor_data['keahlian']); ?>
                            </p>
                        </div>
                    </div>

                    <div class="subject-select">
                        <?php if (empty($subjects_list)): ?>
                            <p>Tutor ini belum memiliki mata kuliah yang tersedia.</p>
                        <?php else: ?>
                            <?php foreach ($subjects_list as $subject): ?>
                                <div class="subject-option <?php echo ($subject_id == $subject['id']) ? 'selected' : ''; ?>" onclick="selectSubject(this)">
                                    <label style="cursor: pointer; width: 100%; display: block;">
                                        <input type="radio" name="subject_id" value="<?php echo $subject['id']; ?>" 
                                               <?php echo ($subject_id == $subject['id']) ? 'checked' : ''; ?> required>
                                        <strong style="font-size: 16px;"><?php echo htmlspecialchars($subject['subject_name']); ?></strong>
                                        <span style="float: right; color: #1a5276; font-weight: bold; font-size: 16px;">
                                            Rp <?php echo number_format($subject['price'], 0, ',', '.'); ?>
                                        </span>
                                        <?php if (!empty($subject['description'])): ?>
                                            <p style="font-size: 14px; color: #666; margin: 8px 0 0 25px;">
                                                <?php echo htmlspecialchars($subject['description']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="btn-group">
                        <a href="../public/search_result.php" class="btn-secondary">Batal</a>
                        <button type="button" class="btn-primary" onclick="nextStep(2)">Lanjut</button>
                    </div>
                </div>
            </div>

            <div class="step-content" id="step2">
                <div class="booking-card">
                    <h2 style="margin-bottom: 20px; color: #1a5276;">Pilih Tanggal & Waktu</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="booking_date" class="form-input" required 
                               min="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Waktu</label>
                        <input type="time" name="booking_time" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-input" rows="4" 
                                  placeholder="Contoh: Saya ingin fokus pada materi Aljabar..."></textarea>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn-secondary" onclick="prevStep(1)">Kembali</button>
                        <button type="button" class="btn-primary" onclick="nextStep(3)">Lanjut</button>
                    </div>
                </div>
            </div>

            <div class="step-content" id="step3">
                <div class="booking-card">
                    <h2 style="margin-bottom: 20px; color: #1a5276;">Konfirmasi Booking</h2>
                    
                    <div class="confirmation-details" id="confirmationDetails">
                        <!-- Akan diisi oleh JavaScript -->
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn-secondary" onclick="prevStep(2)">Kembali</button>
                        <button type="button" class="btn-primary" id="btnPayNow" onclick="submitAndPay()">
                            <i class="bi bi-credit-card"></i> Booking & Bayar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<script>
let currentStep = 1;
const totalSteps = 3;

function selectSubject(element) {
    document.querySelectorAll('.subject-option').forEach(el => el.classList.remove('selected'));
    element.classList.add('selected');
    element.querySelector('input[type="radio"]').checked = true;
}

function updateStepIndicator() {
    for (let i = 1; i <= totalSteps; i++) {
        const stepEl = document.querySelector(`.step-indicator .step:nth-child(${i})`);
        if (stepEl) {
            if (i < currentStep) {
                stepEl.classList.remove('active');
                stepEl.classList.add('completed');
            } else if (i === currentStep) {
                stepEl.classList.add('active');
                stepEl.classList.remove('completed');
            } else {
                stepEl.classList.remove('active', 'completed');
            }
        }
    }
}

function showStep(step) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    document.getElementById(`step${step}`).classList.add('active');
    currentStep = step;
    updateStepIndicator();
    
    if (step === 3) {
        updateConfirmation();
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextStep(step) {
    if (step === 2) {
        const subjectId = document.querySelector('input[name="subject_id"]:checked');
        if (!subjectId) {
            alert('Harap pilih mata kuliah terlebih dahulu');
            return;
        }
    }
    if (step === 3) {
        const date = document.querySelector('input[name="booking_date"]').value;
        const time = document.querySelector('input[name="booking_time"]').value;
        if (!date || !time) {
            alert('Harap isi tanggal dan waktu terlebih dahulu');
            return;
        }
    }
    showStep(step);
}

function prevStep(step) {
    showStep(step);
}

function updateConfirmation() {
    const form = document.getElementById('bookingForm');
    const formData = new FormData(form);
    
    const tutorName = '<?php echo htmlspecialchars($tutor_data['nama_lengkap'] ?? ''); ?>';
    const subjectId = formData.get('subject_id');
    const subjectName = document.querySelector(`input[name="subject_id"][value="${subjectId}"]`)?.parentElement.querySelector('strong')?.textContent || '';
    const subjectPrice = document.querySelector(`input[name="subject_id"][value="${subjectId}"]`)?.parentElement.querySelector('span')?.textContent || '';
    const date = formData.get('booking_date');
    const time = formData.get('booking_time');
    const notes = formData.get('notes');
    
    const dateObj = new Date(date);
    const dateFormatted = dateObj.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    
    document.getElementById('confirmationDetails').innerHTML = `
        <p><strong>Tutor:</strong> <span>${tutorName}</span></p>
        <p><strong>Mata Kuliah:</strong> <span>${subjectName}</span></p>
        <p><strong>Harga:</strong> <span>${subjectPrice}</span></p>
        <p><strong>Tanggal:</strong> <span>${dateFormatted}</span></p>
        <p><strong>Waktu:</strong> <span>${time}</span></p>
        <p><strong>Durasi:</strong> <span>90 menit</span></p>
        ${notes ? `<p><strong>Catatan:</strong> <span>${notes}</span></p>` : ''}
        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">
        <p style="font-size: 12px; color: #666; margin: 0;">
            <i class="bi bi-shield-check"></i> Pembayaran aman melalui Midtrans (Transfer Bank, E-Wallet, Kartu Kredit/Debit).
        </p>
    `;
}

function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

window.onclick = function(event) {
    if (!event.target.matches('button') && !event.target.closest('button')) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const stepIndicator = document.createElement('div');
    stepIndicator.className = 'step-indicator';
    stepIndicator.innerHTML = `
        <div class="step active">1</div>
        <div class="step">2</div>
        <div class="step">3</div>
    `;
    document.querySelector('.booking-header').after(stepIndicator);
    updateStepIndicator();
});
function submitAndPay() {
    const form = document.getElementById('bookingForm');
    const formData = new FormData(form);
    const btn = document.getElementById('btnPayNow');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memproses...';

    // First submit booking via AJAX
    fetch('../../../backend/learner/booking_process.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.booking_id) {
            // Create Midtrans transaction
            return fetch('../../../backend/learner/create_transaction.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ booking_id: data.booking_id })
            }).then(res => res.json());
        } else {
            throw new Error(data.error || 'Gagal membuat booking');
        }
    })
    .then(data => {
        if (data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function() {
                    window.location.href = 'sesi_saya.php?status=payment_success';
                },
                onPending: function() {
                    window.location.href = 'sesi_saya.php?status=payment_pending';
                },
                onError: function() {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-credit-card"></i> Booking & Bayar';
                },
                onClose: function() {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-credit-card"></i> Booking & Bayar';
                }
            });
        } else {
            throw new Error(data.error || 'Gagal membuat transaksi pembayaran');
        }
    })
    .catch(err => {
        alert(err.message);
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-credit-card"></i> Booking & Bayar';
    });
}
</script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-Rr8SHccGS2EF86NA"></script>

<?php require_once '../../layouts/footer.php'; ?>







