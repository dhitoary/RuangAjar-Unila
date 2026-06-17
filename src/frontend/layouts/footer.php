<?php 
if (!isset($assetPath)) {
  $assetPath = "../../../assets/";
}
?>

<footer class="sb-footer">
  <div class="footer-inner">
    <div class="footer-grid">
      <!-- Kolom 1: Info -->
      <div class="footer-col">
        <div style="margin-bottom: 16px; display: inline-flex; align-items: center; gap: 12px;">
          <img src="<?php echo $assetPath; ?>img/logo_unila_resmi.png" alt="Unila Logo" style="height: 50px; width: auto; object-fit: contain;">
          <div>
            <div class="footer-logo-big">RuangAjar</div>
            <div class="footer-logo-sub" style="margin-bottom: 0;">Universitas Lampung</div>
          </div>
        </div>
        <p class="footer-desc">
          Platform Tutor Sebaya resmi untuk mahasiswa Universitas Lampung. Membangun ekosistem belajar yang kolaboratif dan suportif untuk meningkatkan prestasi akademik bersama.
        </p>
        <div class="footer-socials">
          <a href="#"><i class="bi bi-instagram"></i></a>
          <a href="#"><i class="bi bi-twitter-x"></i></a>
          <a href="#"><i class="bi bi-youtube"></i></a>
        </div>
      </div>

      <!-- Kolom 2: Tautan Cepat -->
      <div class="footer-col">
        <h4>Tautan Cepat</h4>
        <ul>
          <li><a href="../public/landing_page.php">Beranda</a></li>
          <li><a href="../public/search_result.php">Cari Tutor</a></li>
          <li><a href="../public/categories.php">Jelajahi Kategori</a></li>
          <li><a href="../public/testimoni.php">Testimoni Mahasiswa</a></li>
        </ul>
      </div>

      <!-- Kolom 3: Kontak & Bantuan -->
      <div class="footer-col">
        <h4>Kontak & Bantuan</h4>
        <ul>
          <li><a href="#"><i class="bi bi-envelope"></i> support@ruangajar.unila.ac.id</a></li>
          <li><a href="#"><i class="bi bi-telephone"></i> +62 812 3456 7890</a></li>
          <li><a href="#"><i class="bi bi-geo-alt"></i> Gedung Rektorat Unila, Jl. Prof. Dr. Ir. Sumantri Brojonegoro</a></li>
          <li><a href="#"><i class="bi bi-question-circle"></i> Pusat Bantuan (FAQ)</a></li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="footer-copy">
        &copy; <?php echo date("Y"); ?> RuangAjar Universitas Lampung. All Rights Reserved.
      </div>
      <div class="footer-bottom-links">
        <a href="#">Syarat & Ketentuan</a>
        <a href="#">Kebijakan Privasi</a>
      </div>
    </div>
  </div>
</footer>

</body>
</html>
