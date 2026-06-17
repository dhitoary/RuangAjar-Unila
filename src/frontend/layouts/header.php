<?php 
if (!isset($assetPath)) {
  $assetPath = "../../../assets/";
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
$userName = $_SESSION['user_name'] ?? '';
$userRole = $_SESSION['user_role'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RuangAjar - Universitas Lampung</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $assetPath ?>css/style.css?v=2.0">
</head>

<body>

<nav class="sb-navbar">
  <div class="sb-nav-container">

    <a href="../public/landing_page.php" class="sb-brand">
      <img src="<?php echo $assetPath ?>img/logo_unila_resmi.png" alt="Unila Logo" style="height: 38px; width: auto; object-fit: contain;">
      <div class="sb-brand-text">
        <span class="sb-brand-name">RuangAjar</span>
        <span class="sb-brand-sub">Universitas Lampung</span>
      </div>
    </a>

    <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
    <ul class="sb-menu">
      <?php if ($isLoggedIn && $userRole === 'learner'): ?>
        <li><a href="../learner/dashboard_mahasiswa.php" class="<?php echo $currentPage == 'dashboard_mahasiswa.php' ? 'active' : ''; ?>">Beranda</a></li>
        <li><a href="../public/search_result.php" class="<?php echo $currentPage == 'search_result.php' ? 'active' : ''; ?>">Cari Tutor</a></li>
        <li><a href="../learner/sesi_saya.php" class="<?php echo $currentPage == 'sesi_saya.php' ? 'active' : ''; ?>">Sesi Saya</a></li>
        <li><a href="../learner/riwayat.php" class="<?php echo $currentPage == 'riwayat.php' ? 'active' : ''; ?>">Riwayat</a></li>
      <?php elseif ($isLoggedIn && $userRole === 'tutor'): ?>
        <li><a href="../tutor/dashboard_tutor.php" class="<?php echo $currentPage == 'dashboard_tutor.php' ? 'active' : ''; ?>">Beranda</a></li>
        <li><a href="../public/search_result.php" class="<?php echo $currentPage == 'search_result.php' ? 'active' : ''; ?>">Cari Tutor</a></li>
        <li><a href="../tutor/mahasiswa_saya.php" class="<?php echo $currentPage == 'mahasiswa_saya.php' ? 'active' : ''; ?>">Mahasiswa Saya</a></li>
      <?php else: ?>
        <li><a href="../public/landing_page.php" class="<?php echo $currentPage == 'landing_page.php' ? 'active' : ''; ?>">Beranda</a></li>
        <li><a href="../public/search_result.php" class="<?php echo $currentPage == 'search_result.php' ? 'active' : ''; ?>">Cari Tutor</a></li>
        <li><a href="../public/categories.php" class="<?php echo $currentPage == 'categories.php' ? 'active' : ''; ?>">Kategori</a></li>
        <li><a href="../public/testimoni.php" class="<?php echo $currentPage == 'testimoni.php' ? 'active' : ''; ?>">Testimoni</a></li>
      <?php endif; ?>
    </ul>

    <div style="display: flex; gap: 10px; align-items: center;">
      <?php if ($isLoggedIn): ?>
        <div style="position: relative;">
          <button onclick="toggleDropdown()" class="sb-daftar" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($userName); ?>
          </button>
          <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border-radius: 10px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); min-width: 200px; z-index: 1000; overflow: hidden;">
            <div style="padding: 14px 16px; border-bottom: 1px solid #eee; background: #f8f9fa;">
              <p style="margin: 0; font-weight: 600; color: #333; font-size: 14px;"><?php echo htmlspecialchars($userName); ?></p>
              <p style="margin: 2px 0 0 0; font-size: 12px; color: #666;"><?php echo ucfirst($userRole); ?></p>
            </div>
            <?php if ($userRole === 'learner'): ?>
              <a href="../learner/profil.php" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px;">
                <i class="bi bi-person"></i> Profil Saya
              </a>
              <a href="../learner/sesi_saya.php" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px; border-top: 1px solid #f0f0f0;">
                <i class="bi bi-calendar-check"></i> Sesi Belajar
              </a>
            <?php elseif ($userRole === 'tutor'): ?>
              <a href="../tutor/dashboard_tutor.php" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px;">
                <i class="bi bi-speedometer2"></i> Dashboard
              </a>
              <a href="../tutor/profil.php" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; font-size: 14px; border-top: 1px solid #f0f0f0;">
                <i class="bi bi-person"></i> Profil Saya
              </a>
            <?php endif; ?>
            <a href="../../../backend/auth/logout.php" style="display: block; padding: 12px 16px; color: #e74c3c; text-decoration: none; font-size: 14px; border-top: 1px solid #f0f0f0;">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </div>
        </div>
      <?php else: ?>
        <a href="../auth/login.php" class="sb-login">Masuk</a>
        <a href="../auth/register.php" class="sb-daftar">Daftar</a>
      <?php endif; ?>
    </div>

  </div>
</nav>

<script>
function toggleDropdown() {
  const dropdown = document.getElementById('userDropdown');
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

window.onclick = function(event) {
  if (!event.target.matches('.sb-daftar') && !event.target.closest('.sb-daftar')) {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown && dropdown.style.display === 'block') {
      dropdown.style.display = 'none';
    }
  }
}
</script>

