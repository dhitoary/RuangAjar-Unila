<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] && isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] === 'tutor') {
        header("Location: ../tutor/dashboard_tutor.php");
        exit();
    } elseif ($_SESSION['user_role'] === 'learner') {
        header("Location: ../learner/dashboard_mahasiswa.php");
        exit();
    }
}

$assetPath = "../../assets/";
include '../../layouts/header.php'; 

require_once '../../../config/database.php';

$query = "SELECT t.id, t.nama_lengkap as nama, t.email, t.keahlian, t.harga_per_sesi, t.rating 
          FROM tutor t 
          WHERE t.status = 'Aktif' 
          ORDER BY t.rating DESC 
          LIMIT 8";
$result = mysqli_query($conn, $query);

$tutorsData = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $mapelQuery = "SELECT nama_mapel FROM tutor_mapel WHERE tutor_id = {$row['id']} LIMIT 1";
        $mapelResult = mysqli_query($conn, $mapelQuery);
        $mapelRow = mysqli_fetch_assoc($mapelResult);
        
        $tutorsData[] = [
            'id' => $row['id'],
            'nama' => $row['nama'],
            'mapel' => $mapelRow['nama_mapel'] ?? $row['keahlian'],
            'harga' => $row['harga_per_sesi'] ?? 100000,
            'rating' => $row['rating'] ?? 4.5
        ];
    }
}

$categoryQuery = "SELECT tm.nama_mapel, COUNT(DISTINCT tm.tutor_id) as tutor_count 
                  FROM tutor_mapel tm
                  INNER JOIN tutor t ON tm.tutor_id = t.id 
                  WHERE t.status = 'Aktif' 
                  GROUP BY tm.nama_mapel 
                  ORDER BY tutor_count DESC";
$categoryResult = mysqli_query($conn, $categoryQuery);

$categoriesData = [];
if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
    while ($row = mysqli_fetch_assoc($categoryResult)) {
        $categoriesData[] = [
            'name' => $row['nama_mapel'],
            'count' => $row['tutor_count']
        ];
    }
}

if (empty($tutorsData)) {
    $tutorsData = [
        ['id' => 1, 'nama' => 'Rizky Ramadhan', 'mapel' => 'Kalkulus Dasar', 'harga' => 100000, 'rating' => 4.9],
        ['id' => 2, 'nama' => 'Aulia Putri', 'mapel' => 'Bahasa Inggris', 'harga' => 90000, 'rating' => 5.0],
        ['id' => 3, 'nama' => 'Dimas Wahyu', 'mapel' => 'Fisika Dasar', 'harga' => 95000, 'rating' => 4.7],
        ['id' => 4, 'nama' => 'Nadia Fitri', 'mapel' => 'Kimia Dasar', 'harga' => 85000, 'rating' => 4.8],
        ['id' => 5, 'nama' => 'Farhan Akbar', 'mapel' => 'Biologi Umum', 'harga' => 80000, 'rating' => 4.6],
        ['id' => 6, 'nama' => 'Sinta Maharani', 'mapel' => 'Algoritma & Pemrograman', 'harga' => 75000, 'rating' => 4.5],
        ['id' => 7, 'nama' => 'Adi Pratama', 'mapel' => 'Pengantar Ekonomi', 'harga' => 85000, 'rating' => 4.7],
        ['id' => 8, 'nama' => 'Maya Sari', 'mapel' => 'Struktur Data', 'harga' => 70000, 'rating' => 4.4]
    ];
}
?>

<main class="site-main">
  <!-- HERO -->
  <section class="hero-section" role="region" aria-label="Hero">
    <div class="hero-slider">
      <div class="slide" style="background-image: url('<?php echo $assetPath; ?>img/hero-slide-1.png');"></div>
      <div class="slide" style="background-image: url('<?php echo $assetPath; ?>img/hero-slide-2.png');"></div>
      <div class="slide" style="background-image: url('<?php echo $assetPath; ?>img/hero-slide-3.png');"></div>
    </div>
    <div class="hero-overlay">
      <div class="hero-inner">
        <div class="hero-badge">Platform Tutor Sebaya #1 di Universitas Lampung</div>
        <h1 class="hero-title" style="margin-top: 18px;">
          Belajar Lebih Mudah<br>
          dengan <span class="accent">Tutor Sebaya</span>
        </h1>
        <p class="hero-sub">
          RuangAjar menghubungkan mahasiswa Unila yang butuh bimbingan 
          dengan kating, asisten lab, dan mahasiswa berprestasi sebagai tutor.
        </p>
      </div>
    </div>
  </section>

  <!-- CONTAINER -->
  <div class="container">
    <!-- SEARCH -->
    <div class="search-box" role="search" aria-label="Pencarian tutor">
      <input id="searchInput" type="text" placeholder="Cari mata kuliah atau nama tutor..." aria-label="Cari tutor">
      <button id="btnSearch" class="btn-search" type="button">Cari Tutor</button>
    </div>

  <!-- KATEGORI POPULER -->
  <section class="section-category" aria-label="Kategori populer" style="padding: 80px 0;">
    <div class="section-title">Jelajahi Fakultas</div>
    <div class="section-desc">Temukan tutor dari berbagai Fakultas di Universitas Lampung</div>
    
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
      <?php 
      $categoriesData = [
        ['name' => 'Fakultas Teknik'],
        ['name' => 'FMIPA'],
        ['name' => 'Fakultas Kedokteran'],
        ['name' => 'FEB'],
        ['name' => 'Fakultas Hukum'],
        ['name' => 'FISIP'],
        ['name' => 'FKIP'],
        ['name' => 'Fakultas Pertanian']
      ];
      
      $categoryIcons = [
        'Teknik' => 'bi-gear-wide-connected',
        'FMIPA' => 'bi-code-square',
        'Kedokteran' => 'bi-heart-pulse',
        'FEB' => 'bi-graph-up-arrow',
        'Hukum' => 'bi-bank',
        'FISIP' => 'bi-people',
        'FKIP' => 'bi-book-half',
        'Pertanian' => 'bi-tree'
      ];
      
      $displayedCount = 0;
      foreach ($categoriesData as $cat) {
        if ($displayedCount >= 8) break;
        $mapel = $cat['name'];
        
        $icon = 'bi-journal-text';
        foreach ($categoryIcons as $key => $value) {
          if (stripos($mapel, $key) !== false || stripos($key, $mapel) !== false) {
            $icon = $value;
            break;
          }
        }
      ?>
        <div class="category-card-item" 
             style="background: var(--primary-soft); padding: 40px 24px; border-radius: 16px; text-align: center; transition: all 0.3s; cursor: pointer;"
             onmouseover="this.style.background='var(--primary)'; this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 32px rgba(26,82,118,0.2)'; this.querySelector('.cat-icon').style.color='#fff'; this.querySelector('.cat-title').style.color='#fff';"
             onmouseout="this.style.background='var(--primary-soft)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.querySelector('.cat-icon').style.color='var(--primary)'; this.querySelector('.cat-title').style.color='var(--dark)';">
          <div style="width: 72px; height: 72px; margin: 0 auto 18px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="bi <?php echo $icon; ?> cat-icon" style="font-size: 32px; color: var(--primary); transition: color 0.3s;"></i>
          </div>
          <div class="cat-title" style="font-size: 16px; font-weight: 700; color: var(--dark); transition: color 0.3s;">
            <?php echo htmlspecialchars($mapel); ?>
          </div>
        </div>
      <?php 
        $displayedCount++;
      } 
      ?>
    </div>
    
    <div style="text-align: center;">
      <a href="categories.php" style="display: inline-flex; align-items: center; gap: 10px; padding: 14px 36px; background: var(--primary); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 15px; transition: all 0.2s;" 
         onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-2px)'" 
         onmouseout="this.style.background='var(--primary)'; this.style.transform='translateY(0)'">
        Lihat Semua Kategori
        <i class="bi bi-arrow-right"></i>
      </a>
    </div>
  </section>

  <!-- CARA KERJA -->
  <section class="section-steps" aria-label="Cara kerja">
    <div class="section-title">Cara Kerja</div>
    <div class="section-desc">3 langkah mudah untuk mulai belajar bersama tutor sebaya di Unila</div>

    <div class="steps">
      <div class="step-card">
        <div class="step-number">1</div>
        <div class="step-title" style="margin-top: 10px;">Cari & Pilih Tutor</div>
        <div class="step-desc">Cari tutor berdasarkan mata kuliah yang Anda butuhkan.</div>
      </div>
      <div class="step-card">
        <div class="step-number">2</div>
        <div class="step-title" style="margin-top: 10px;">Booking & Bayar</div>
        <div class="step-desc">Pilih jadwal, lakukan pembayaran online melalui Midtrans.</div>
      </div>
      <div class="step-card">
        <div class="step-number">3</div>
        <div class="step-title" style="margin-top: 10px;">Belajar & Beri Ulasan</div>
        <div class="step-desc">Ikuti sesi belajar, lalu beri penilaian untuk tutor Anda.</div>
      </div>
    </div>
  </section>

  <!-- REKOMENDASI TUTOR -->
  <section class="section-rekomendasi" aria-label="Rekomendasi tutor">
    <div class="section-title">Rekomendasi Tutor</div>
    <div class="section-desc">Tutor terbaik dan terpercaya untuk berbagai mata kuliah</div>
    <div class="grid" id="tutorContainer"></div>
  </section>

  <!-- TESTIMONIAL -->
  <section class="section-testimoni" aria-label="Testimoni" style="padding: 80px 0;">
    <div class="section-title">Apa Kata Mahasiswa</div>
    <div class="section-desc">Testimoni nyata dari mahasiswa Unila yang telah merasakan bimbingan berkualitas</div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; max-width: 1200px; margin: 0 auto; padding: 0 24px;">
      <?php
      $testimonis = [
        ['text' => 'Tutor Kalkulus yang mengajar saya sangat sabar dan detail. Nilai UAS saya naik drastis! Sangat terbantu dengan RuangAjar.', 'nama' => 'Alya Natasya', 'info' => 'Mahasiswa Teknik Informatika 2024', 'mapel' => 'Kalkulus Dasar', 'init' => 'AN', 'grad' => 'linear-gradient(135deg, #1a5276, #2e86c1)'],
        ['text' => 'Persiapan UTS Fisika Dasar jadi lebih terarah dengan tutor dari RuangAjar. Metode belajarnya efektif dan jadwal fleksibel.', 'nama' => 'Rizki Pratama', 'info' => 'Mahasiswa FMIPA 2023', 'mapel' => 'Fisika Dasar', 'init' => 'RP', 'grad' => 'linear-gradient(135deg, #27ae60, #2ecc71)'],
        ['text' => 'Belajar Algoritma & Pemrograman jadi lebih mudah dipahami. Kating yang jadi tutor bisa bikin materi praktis dan relevan.', 'nama' => 'Dinda Maharani', 'info' => 'Mahasiswa Ilmu Komputer 2024', 'mapel' => 'Algoritma & Pemrograman', 'init' => 'DM', 'grad' => 'linear-gradient(135deg, #2e86c1, #3498db)'],
      ];
      foreach ($testimonis as $t):
      ?>
      <div style="background: white; padding: 32px; border-radius: 14px; box-shadow: 0 4px 24px rgba(26,82,118,0.08); transition: all 0.3s;"
           onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 32px rgba(26,82,118,0.15)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 24px rgba(26,82,118,0.08)'">
        <div style="display: flex; gap: 4px; margin-bottom: 16px;">
          <?php for($i=0;$i<5;$i++): ?><i class="bi bi-star-fill" style="color: #f39c12; font-size: 16px;"></i><?php endfor; ?>
        </div>
        <p style="font-size: 15px; line-height: 1.7; color: #475569; font-style: italic; margin: 0 0 24px;">
          "<?php echo $t['text']; ?>"
        </p>
        <div style="border-top: 1px solid #eee; padding-top: 18px; display: flex; align-items: center; gap: 14px;">
          <div style="width: 48px; height: 48px; background: <?php echo $t['grad']; ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; font-weight: 700;">
            <?php echo $t['init']; ?>
          </div>
          <div>
            <div style="font-weight: 700; color: var(--dark); font-size: 15px;"><?php echo $t['nama']; ?></div>
            <div style="color: #94a3b8; font-size: 13px;"><?php echo $t['info']; ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- FAQ -->
  <section class="section-faq" aria-label="FAQ">
    <div class="section-title">Pertanyaan Umum</div>
    <div class="section-desc">Jawaban singkat untuk pertanyaan yang sering diajukan</div>

    <div class="faq-list" style="max-width:800px;margin:24px auto 60px;">
      <div class="faq-item" data-idx="0">
        <div class="faq-question">Bagaimana cara verifikasi tutor?</div>
        <div class="faq-answer">Tutor wajib mengunggah KTM dan transkrip nilai. Admin akan memverifikasi sebelum akun aktif.</div>
      </div>
      <div class="faq-item" data-idx="1">
        <div class="faq-question">Apakah ada jaminan kualitas?</div>
        <div class="faq-answer">Sistem rating dan review membantu memastikan kualitas tutor. Anda bisa melihat ulasan mahasiswa sebelumnya.</div>
      </div>
      <div class="faq-item" data-idx="2">
        <div class="faq-question">Bagaimana cara pembayaran?</div>
        <div class="faq-answer">Pembayaran dilakukan secara online melalui Midtrans (transfer bank, e-wallet, kartu kredit/debit).</div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="section-cta" aria-label="Call to action">
    <div style="max-width: 700px; margin: 0 auto;">
      <h2 style="font-size: 2.2rem; font-weight: 800; color: white; margin: 0 0 12px; line-height: 1.3;">
        Siap Meningkatkan Prestasi Akademik?
      </h2>
      <p style="color: rgba(255,255,255,0.8); font-size: 1rem; margin: 0 0 28px;">Bergabung sekarang dan temukan tutor terbaik untuk mata kuliah Anda</p>
      <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
        <a href="../auth/register.php" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: white; color: var(--primary); text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 15px; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
          <i class="bi bi-person-plus"></i> Daftar Sekarang
        </a>
        <a href="search_result.php" style="display: inline-flex; align-items: center; gap: 8px; padding: 14px 32px; background: rgba(255,255,255,0.15); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 15px; border: 1px solid rgba(255,255,255,0.3); transition: all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
          <i class="bi bi-search"></i> Cari Tutor
        </a>
      </div>
    </div>
  </section>
  </div>
</main>

<?php include '../../layouts/footer.php'; ?>

<script>
  const tutorsData = <?php echo json_encode($tutorsData); ?>;
  function rupiah(n){ return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); }

  function renderTutors(list){
    const container = document.getElementById('tutorContainer');
    if(!container) return;
    container.innerHTML = '';
    list.forEach(t => {
      const el = document.createElement('div');
      el.className = 'tutor-card';
      el.innerHTML = `
        <div class="tutor-photo">${t.nama.split(' ')[0].charAt(0)}</div>
        <div class="tutor-name">${t.nama}</div>
        <div class="tutor-sub">${t.mapel}</div>
        <div class="tutor-meta">
          <div class="rating">&#9733; ${t.rating}</div>
          <div class="tutor-price">Rp ${rupiah(t.harga)}</div>
        </div>
        <a href="detail_tutor.php?id=${t.id}&nama=${encodeURIComponent(t.nama)}&mapel=${encodeURIComponent(t.mapel)}&harga=${t.harga}&rating=${t.rating}" class="btn-detail">Detail Tutor</a>
      `;
      container.appendChild(el);
    });
  }

  renderTutors(tutorsData);

  const searchInput = document.getElementById('searchInput');
  const btnSearch = document.getElementById('btnSearch');
  if(searchInput){
    searchInput.addEventListener('input', function(e){
      const q = e.target.value.toLowerCase().trim();
      const filtered = tutorsData.filter(t => t.nama.toLowerCase().includes(q) || t.mapel.toLowerCase().includes(q));
      renderTutors(filtered);
    });
    btnSearch && btnSearch.addEventListener('click', function(){
      const q = (searchInput.value||'').toLowerCase().trim();
      const filtered = tutorsData.filter(t => t.nama.toLowerCase().includes(q) || t.mapel.toLowerCase().includes(q));
      renderTutors(filtered);
    });
  }

  document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', function(){
      const isActive = this.classList.contains('active');
      document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
      if(!isActive) this.classList.add('active');
    });
  });
</script>
