<style>
.sb-navbar {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
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
    text-decoration: none;
}
.sb-brand img {
    height: 44px;
    width: auto;
    object-fit: contain;
}
.sb-brand-text {
    display: flex;
    flex-direction: column;
}
.sb-brand-name {
    font-size: 18px;
    font-weight: 800;
    color: #1a5276;
    letter-spacing: -0.3px;
}
.sb-brand-sub {
    font-size: 10px;
    font-weight: 600;
    color: #666;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.sb-menu {
    display: flex;
    gap: 30px;
    list-style: none;
    margin: 0;
    padding: 0;
}
.sb-menu li a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
    transition: all 0.3s;
    padding: 8px 0 !important;
    border-bottom: 2px solid transparent;
}
.sb-menu li a:hover, .sb-menu li a.active {
    color: #1a5276;
    border-bottom-color: #1a5276;
    background: transparent !important;
    font-weight: 600 !important;
    padding: 8px 0 !important;
}
.sb-daftar {
    display: flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #1a5276, #2e86c1);
    color: white;
    padding: 10px 25px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
}
</style>

<nav class="sb-navbar">
    <div class="sb-nav-container">
        <a href="dashboard_mahasiswa.php" class="sb-brand">
            <img src="../../../assets/img/logo_unila_resmi.png" alt="Unila Logo">
            <div class="sb-brand-text">
                <span class="sb-brand-name">RuangAjar</span>
                <span class="sb-brand-sub">Universitas Lampung</span>
            </div>
        </a>

        <ul class="sb-menu">
            <li><a href="dashboard_mahasiswa.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard_mahasiswa.php' ? 'active' : ''; ?>">Beranda</a></li>
            <li><a href="cari_tutor.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'cari_tutor.php' ? 'active' : ''; ?>">Cari Tutor</a></li>
            <li><a href="sesi_saya.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'sesi_saya.php' ? 'active' : ''; ?>">Sesi Saya</a></li>
            <li><a href="riwayat.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'active' : ''; ?>">Riwayat Booking</a></li>
        </ul>

        <div style="display: flex; gap: 10px; align-items: center;">
            <div style="position: relative;">
                <button onclick="toggleDropdown()" class="sb-daftar">
                    <i class="bi bi-person-circle"></i> <?php echo isset($siswa_data['nama_lengkap']) ? htmlspecialchars($siswa_data['nama_lengkap']) : 'Profil'; ?>
                </button>
                <div id="userDropdown" style="display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 200px; z-index: 1000;">
                    <div style="padding: 12px 16px; border-bottom: 1px solid #eee;">
                        <p style="margin: 0; font-weight: 600; color: #333;"><?php echo isset($siswa_data['nama_lengkap']) ? htmlspecialchars($siswa_data['nama_lengkap']) : 'Profil'; ?></p>
                        <p style="margin: 5px 0 0 0; font-size: 12px; color: #666;"><?php echo isset($siswa_data['jenjang']) && isset($siswa_data['kelas']) ? htmlspecialchars($siswa_data['jenjang'] . ' - ' . $siswa_data['kelas']) : ''; ?></p>
                    </div>
                    <a href="profil.php" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; border-bottom: 1px solid #eee;">
                        <i class="bi bi-person"></i> Profil Saya
                    </a>
                    <a href="sesi_saya.php" style="display: block; padding: 12px 16px; color: #333; text-decoration: none; border-bottom: 1px solid #eee;">
                        <i class="bi bi-calendar-check"></i> Sesi Belajar
                    </a>
                    <a href="../../../backend/auth/logout.php" style="display: block; padding: 12px 16px; color: #dc3545; text-decoration: none;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>
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
