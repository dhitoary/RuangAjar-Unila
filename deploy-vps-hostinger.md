# 🚀 Panduan Deploy RuangAjar Unila — VPS Hostinger (Production-Safe)

> **Target:** Deploy aplikasi RuangAjar Unila (PHP Native + MariaDB Alpine) ke VPS Hostinger yang **sudah menjalankan 16 kontainer produksi**, tanpa mengganggu kluster MER System, POLARIS WebGIS, maupun stack Monitoring/Telemetri yang sedang aktif.
>
> **Konteks:** Proyek ini dideploy menggunakan container Docker dengan alokasi resource RAM dan storage seminimal mungkin agar hemat dan stabil berdampingan dengan kontainer lain. Akses dilayani dengan format **HTTPS** menggunakan subdomain **ruangajar-unila.firmanfarel.site**.

---

## 📋 Daftar Isi

1. [Peta Konflik & Resolusi Port](#1-peta-konflik--resolusi-port)
2. [Konfigurasi DNS Subdomain di Hostinger](#2-konfigurasi-dns-subdomain-di-hostinger)
3. [Akses VPS & Pembuatan User `ruangajar-unila`](#3-akses-vps--pembuatan-user-ruangajar-unila)
4. [Upload Project ke VPS](#4-upload-project-ke-vps)
5. [Konfigurasi Docker Compose Production](#5-konfigurasi-docker-compose-production)
6. [Build & Jalankan Container](#6-build--jalankan-container)
7. [Inisialisasi & Import Database](#7-inisialisasi--import-database)
8. [Konfigurasi Nginx Reverse Proxy (Host Container)](#8-konfigurasi-nginx-reverse-proxy-host-container)
9. [Setup SSL & HTTPS (Cloudflare Origin Pulls)](#9-setup-ssl--https-cloudflare-origin-pulls)
10. [Konfigurasi Firewall (UFW)](#10-konfigurasi-firewall-ufw)
11. [Verifikasi & Testing](#11-verifikasi--testing)
12. [Quick Reference — Perintah Penting](#12-quick-reference--perintah-penting)

---

## 1. Peta Konflik & Resolusi Port

Sebelum melakukan deploy, kita **wajib** memetakan seluruh port yang sudah terpakai di VPS agar tidak terjadi tabrakan. Berikut adalah peta okupasi port saat ini beserta resolusinya untuk RuangAjar Unila.

### 1.1 — Peta Okupasi Port Saat Ini (16 Kontainer Aktif)

| Kontainer | Service / Image | Port Binding Host | Status |
|-----------|-----------------|-------------------|--------|
| `mer-web-prod` | Nginx (`nginx:1.27-alpine`) | `0.0.0.0:80`, `0.0.0.0:443` | 🔴 Global (Proxy Utama) |
| `mer-db-prod` | PostgreSQL 16 | `127.0.0.1:5432` | 🔴 Terpakai |
| `mer-redis-prod` | Redis 7 | `127.0.0.1:6379` | 🔴 Terpakai |
| `mer-web-staging` | Nginx (`nginx:1.27-alpine`) | `127.0.0.1:8080` | 🔴 Terpakai |
| `mer-db-staging` | PostgreSQL 16 | `127.0.0.1:5433` | 🔴 Terpakai |
| `mer-grafana` | Grafana | `127.0.0.1:3000` | 🔴 Terpakai |
| `mer-loki` | Loki | `127.0.0.1:3100` | 🔴 Terpakai |
| `polaris-frontend` | React + Nginx | `172.20.1.1:3010` | 🔴 Terpakai |
| `polaris-api` | Express.js | `172.20.1.1:5010` | 🔴 Terpakai |
| `production-app-1` | PHP / Laravel | Internal `9000` | 🟢 Internal (No Conflict) |
| `mer-app-staging` | PHP / Laravel | Internal `9000` | 🟢 Internal (No Conflict) |
| `mer-redis-staging`| Redis 7 | Internal `6379` | 🟢 Internal (No Conflict) |
| `polaris-postgis` | PostGIS | Internal `5432` | 🟢 Internal (No Conflict) |
| `mer-promtail` | Promtail | — | 🟢 Internal (No Conflict) |
| `mer-uptime-kuma` | Uptime Kuma | — | 🟢 Internal (No Conflict) |
| `mer-netdata` | Netdata | — | 🟢 Internal (No Conflict) |

### 1.2 — Resolusi Port untuk RuangAjar Unila

Untuk menghindari konflik port, konfigurasi alokasi port di-set sebagai berikut:

| Komponen RuangAjar | Port Internal Kontainer | Port Host Mapping | Alasan |
|--------------------|------------------------|-------------------|--------|
| `ruangajar-app` (Apache+PHP) | `80` | `172.20.1.1:8090` | Port `8090` steril dan aman digunakan |
| `ruangajar-db` (MariaDB) | `3306` | **Tidak di-expose** | Untuk keamanan maksimum, database hanya bisa diakses via Docker internal network |

> [!IMPORTANT]
> Port host binding menggunakan prefix `172.20.1.1:` (Docker bridge gateway IP) sehingga **tidak bisa diakses dari internet secara langsung** (hanya bisa diakses secara internal oleh Nginx reverse proxy di kontainer `mer-web-prod`).

---

## 2. Konfigurasi DNS Subdomain di Hostinger

### Langkah 2.1 — Login ke Hostinger Panel
1. Buka [https://hpanel.hostinger.com](https://hpanel.hostinger.com)
2. Login dengan akun Anda.
3. Pilih domain `firmanfarel.site` dari menu Domain.

### Langkah 2.2 — Buat DNS Record Baru
Masuk ke menu **DNS / Nameservers** → **DNS Records**, lalu tambahkan record berikut:

| Type | Name | Value | TTL |
|------|------|-------|-----|
| `A` | `ruangajar-unila` | `<IP_VPS_ANDA>` | 3600 |

*Ganti `<IP_VPS_ANDA>` dengan IP publik VPS Hostinger Anda.*

---

## 3. Akses VPS & Pembuatan User `ruangajar-unila`

Untuk menjaga keamanan (Least Privilege Access), kita membuat user baru bernama `ruangajar-unila` agar direktori project dan kontainer terisolasi dari proyek MER maupun POLARIS.

### 3.1 — SSH ke VPS sebagai Admin Sudo
Dari komputer lokal Anda (PowerShell atau CMD), jalankan SSH menggunakan IP VPS Anda. 

**Jika menggunakan Windows PowerShell:**
```powershell
# Jalankan dengan format path Windows untuk SSH Key Anda
ssh -p 49152 -i "$HOME\.ssh\id_ed25519" firmanfarelrichardo@<IP_VPS_ANDA>
```
*(Catatan: Jika SSH Key Anda menggunakan nama lain seperti `id_rsa`, ganti `id_ed25519` menjadi `id_rsa`).*

**Jika menggunakan Git Bash / Linux Subsystem (WSL):**
```bash
ssh -p 49152 -i ~/.ssh/id_ed25519 firmanfarelrichardo@<IP_VPS_ANDA>
```

### 3.2 — Buat User Baru
Jalankan perintah berikut di VPS:
```bash
# Buat user baru dengan nama ruangajar-unila
sudo adduser --disabled-password --gecos "RuangAjar Unila Operator" ruangajar-unila
```
*(Catatan: Menggunakan huruf kecil `ruangajar-unila` adalah standar Linux. Jika Anda ingin menggunakan format persis seperti di request, jalankan dengan command `sudo adduser --force-badname RuangAjar-Unila`).*

### 3.3 — Daftarkan ke Grup Docker & Setup SSH Key
Jalankan di VPS:
```bash
# Tambahkan ke grup docker agar bisa menjalankan perintah docker tanpa sudo
sudo usermod -aG docker ruangajar-unila

# Buat folder ssh untuk akses tanpa password
sudo mkdir -p /home/ruangajar-unila/.ssh
sudo chmod 700 /home/ruangajar-unila/.ssh

# Copy public key authorized dari admin utama
sudo cp /home/firmanfarelrichardo/.ssh/authorized_keys /home/ruangajar-unila/.ssh/authorized_keys
sudo chmod 600 /home/ruangajar-unila/.ssh/authorized_keys
sudo chown -R ruangajar-unila:ruangajar-unila /home/ruangajar-unila/.ssh
```

### 3.4 — Verifikasi User
Jalankan di VPS:
```bash
id ruangajar-unila
# Output yang diharapkan:
# uid=1004(ruangajar-unila) gid=1004(ruangajar-unila) groups=1004(ruangajar-unila),998(docker)
```

### 3.5 — Cara Berpindah ke User `ruangajar-unila` di VPS
Karena user `ruangajar-unila` dibuat dengan opsi `--disabled-password`, user ini tidak memiliki password login konvensional. Oleh karena itu, menjalankan perintah `su - ruangajar-unila` secara langsung akan meminta password yang tidak pernah diset, sehingga memicu pesan error **"su: Authentication failure"**.

Untuk berpindah dari user admin Anda (`firmanfarelrichardo`) ke user `ruangajar-unila` di VPS, Anda harus menyertakan perintah `sudo`:

```bash
# Berpindah ke user ruangajar-unila secara langsung (tanpa password ruangajar-unila)
sudo su - ruangajar-unila

# Atau menggunakan alternatif command:
sudo -i -u ruangajar-unila
```
*(Catatan: Perintah ini hanya akan meminta password dari user `firmanfarelrichardo` Anda sendiri jika sesi sudo telah kedaluwarsa, bukan password dari user ruangajar-unila).*

---

## 4. Upload Project ke VPS

Semua perintah transfer menggunakan port SSH custom `49152`. Karena Anda menggunakan Windows (PowerShell/CMD), program `rsync` tidak terinstall secara bawaan. Gunakan opsi di bawah ini:

### Opsi A — Via Git (Sangat Direkomendasikan & Paling Praktis)
Metode ini paling aman dan tidak rentan masalah path atau error Windows.

1. Push project lokal Anda ke repository Git (GitHub/GitLab).
2. SSH ke VPS sebagai user `ruangajar-unila`.
3. Jalankan git clone di VPS langsung:
   ```bash
   cd /home/ruangajar-unila
   git clone https://github.com/<USERNAME>/RuangAjar-Unila.git app
   ```

---

### Opsi B — Via SCP (Bawaan Windows PowerShell / CMD)
Gunakan Windows PowerShell untuk mengirim folder project langsung ke VPS.

**Jika menggunakan SSH Key di PowerShell lokal:**
```powershell
# Gunakan backtick (`) untuk melanjutan baris di PowerShell.
# Pastikan path folder project lokal Anda sesuai.
scp -P 49152 -i "$HOME\.ssh\id_ed25519" -r C:\laragon\www\RuangAjar-Unila `
  ruangajar-unila@<IP_VPS_ANDA>:/home/ruangajar-unila/app/
```
*(Catatan: Jika nama file key Anda adalah `id_rsa`, ganti `id_ed25519` dengan `id_rsa`. Jika path SSH Key Anda berada di folder lain, sesuaikan path `-i` tersebut).*

**Jika SSH Key sudah terdaftar di SSH Agent Windows (atau tanpa flag `-i`):**
```powershell
scp -P 49152 -r C:\laragon\www\RuangAjar-Unila ruangajar-unila@<IP_VPS_ANDA>:/home/ruangajar-unila/app/
```

> [!CAUTION]
> Pastikan folder upload lokal seperti `src/uploads/` atau file `.env` lokal tidak ikut terkirim secara mentah atau jika terkirim, sesuaikan kembali di VPS agar tidak menimpa data server.


---

## 5. Konfigurasi Docker Compose Production

Docker konfigurasi di VPS sudah disesuaikan agar seminimal mungkin menggunakan memory.

### Langkah 5.1 — Buat File `.env` di VPS
SSH ke VPS sebagai user `ruangajar-unila` (Gunakan path SSH Key Windows Anda, contoh: `"$HOME\.ssh\id_ed25519"` atau `"$HOME\.ssh\id_rsa"`):
```bash
ssh -p 49152 -i "$HOME\.ssh\id_ed25519" ruangajar-unila@<IP_VPS_ANDA>
```
*(Catatan: Sesuaikan nama key atau hilangkan flag `-i` jika menggunakan SSH agent).*
Buat file environment variabel:
```bash
cd /home/ruangajar-unila/app
nano .env
```
Isi dengan kredensial yang aman:
```env
# Database Credentials
DB_ROOT_PASSWORD=KetikRootPasswordKuatDiSini_2026!
DB_USER=ruangajar_user
DB_PASS=KetikUserPasswordKuatDiSini_2026!
DB_NAME=ruangajar
```
Amankan hak akses file `.env`:
```bash
chmod 600 .env
```

---

## 6. Build & Jalankan Container

Gunakan perintah `docker compose` dengan menggabungkan base file dan override production.

### Langkah 6.1 — Jalankan Build
```bash
cd /home/ruangajar-unila/app
docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d
```

### Langkah 6.2 — Cek Status Container
```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml ps
```
Output yang diharapkan:
```
NAME            IMAGE                  STATUS                  PORTS
ruangajar-app   ruangajar-unila-app    Up                      172.20.1.1:8090->80/tcp
ruangajar-db    mariadb:10.11-alpine   Up (healthy)            3306/tcp
```
*(Perhatikan bahwa database `ruangajar-db` statusnya harus `healthy` dan portnya tidak di-expose keluar).*

---

## 7. Inisialisasi & Import Database

Karena ini pertama kali dideploy, kita harus meng-import data schema awal ke database container.

### Langkah 7.1 — Import File SQL
Kita jalankan restore database dari file sql bawaan project:
```bash
docker exec -i ruangajar-db mysql -u ruangajar_user -pGantiDenganDBPassAnda ruangajar < database/ruangajar.sql
```
*(Pastikan password ditulis rapat setelah parameter `-p`).*

### Langkah 7.2 — Verifikasi Tabel Berhasil Terbuat
```bash
docker exec -it ruangajar-db mysql -u ruangajar_user -pGantiDenganDBPassAnda -e "SHOW TABLES IN ruangajar;"
```

---

## 8. Konfigurasi Nginx Reverse Proxy (Host Container)

Layanan Nginx utama berjalan di dalam kontainer `mer-web-prod`. Kita perlu mendaftarkan server block baru agar Nginx di container tersebut mengarahkan request subdomain ke container `ruangajar-app` pada port `172.20.1.1:8090`.

### Langkah 8.1 — Edit Config Nginx
Masuk kembali sebagai admin `firmanfarelrichardo` (sudo user) menggunakan SSH key Anda:
```bash
ssh -p 49152 -i "$HOME\.ssh\id_ed25519" firmanfarelrichardo@<IP_VPS_ANDA>
```
*(Catatan: Sesuaikan nama key atau hilangkan flag `-i` jika menggunakan SSH agent).*
Buka file konfigurasi Nginx:
```bash
sudo nano /var/www/mer-system/production/deployment/production/nginx.conf
```

### Langkah 8.2 — Tambahkan Server Block Baru
Gulir ke bagian akhir (di dalam lingkup `http { ... }`), kemudian sisipkan server block berikut:

```nginx
    # ============================================================
    # RuangAjar Unila — Application Reverse Proxy
    # Subdomain : ruangajar-unila.firmanfarel.site
    # Upstream  : Host IP -> 172.20.1.1:8090
    # ============================================================
    server {
        listen 443 ssl;
        server_name ruangajar-unila.firmanfarel.site;

        # --- Sertifikat SSL Cloudflare ---
        ssl_certificate /etc/ssl/cloudflare/origin-cert.pem;
        ssl_certificate_key /etc/ssl/cloudflare/origin-key.pem;
        ssl_client_certificate /etc/ssl/cloudflare/authenticated-origin-pull-ca.pem;
        ssl_verify_client on;

        ssl_protocols TLSv1.2 TLSv1.3;
        ssl_ciphers 'ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384';
        ssl_prefer_server_ciphers on;

        # Security Headers
        add_header X-Content-Type-Options "nosniff" always;
        add_header X-Frame-Options "DENY" always;
        add_header X-XSS-Protection "1; mode=block" always;
        add_header Referrer-Policy "strict-origin-when-cross-origin" always;

        client_max_body_size 10m;

        location / {
            proxy_pass http://172.20.1.1:8090;
            proxy_http_version 1.1;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_set_header X-Forwarded-Proto $scheme;

            # Timeout settings
            proxy_connect_timeout 60s;
            proxy_send_timeout 60s;
            proxy_read_timeout 60s;
        }

        # Cache file statis (CSS, JS, Images)
        location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2)$ {
            proxy_pass http://172.20.1.1:8090;
            proxy_set_header Host $host;
            expires 30d;
            add_header Cache-Control "public, immutable";
        }
    }
```

### Langkah 8.3 — Test Sintaksis & Reload Nginx
Jangan langsung melakukan reload Nginx. Verifikasi terlebih dahulu agar tidak terjadi downtime global:
```bash
# 1. Test Syntax
sudo docker exec mer-web-prod nginx -t

# Jika output: "syntax is ok" dan "test is successful", jalankan reload:
# 2. Reload Nginx
sudo docker exec mer-web-prod nginx -s reload
```

---

## 9. Setup SSL & HTTPS (Cloudflare Origin Pulls)

Karena domain `firmanfarel.site` menggunakan Cloudflare dengan **Cloudflare Authenticated Origin Pulls**, subdomain baru `ruangajar-unila.firmanfarel.site` secara otomatis terenkripsi penuh via HTTPS menggunakan sertifikat Cloudflare origin yang sudah terpasang. 
Anda **tidak perlu** menginstal Certbot / Let's Encrypt secara terpisah di host OS.

---

## 10. Konfigurasi Firewall (UFW)

Karena kontainer `ruangajar-app` berjalan di port internal dan hanya diakses via reverse proxy Nginx pada port standard (`80/443`), Anda **tidak perlu membuka port baru di UFW**. Konfigurasi firewall tetap steril dan aman.

---

## 11. Verifikasi & Testing

Lakukan serangkaian pengetesan berikut untuk memastikan sistem berjalan aman dan zero-conflict.

### 11.1 — Uji Akses Website
Buka browser dan buka:
* **`https://ruangajar-unila.firmanfarel.site`**
  - Pastikan halaman landing page **RuangAjar Unila** berhasil termuat dengan ikon gembok SSL aktif.
  - Coba akses menu pencarian tutor atau login untuk memastikan database terkoneksi dengan sukses.

### 11.2 — Cek Isolasi Terhadap Kontainer Lain
Pastikan kontainer MER System dan POLARIS tidak terganggu:
```bash
# Pastikan polaris masih berjalan normal
curl -sI http://172.20.1.1:3010 | head -n 1
# Pastikan Grafana masih online
curl -sI http://127.0.0.1:3000 | head -n 1
```

---

## 12. Quick Reference — Perintah Penting

### Mengelola Kontainer RuangAjar Unila (Sebagai User `ruangajar-unila`)
```bash
cd /home/ruangajar-unila/app

# Jalankan Container (Build ulang jika ada perubahan file)
docker compose -f docker-compose.yml -f docker-compose.prod.yml up --build -d

# Mematikan Container
docker compose -f docker-compose.yml -f docker-compose.prod.yml down

# Merestart Container
docker compose -f docker-compose.yml -f docker-compose.prod.yml restart

# Melihat logs
docker compose -f docker-compose.yml -f docker-compose.prod.yml logs -f
```

### Mengelola Nginx Host (Sebagai Admin Sudo)
```bash
# Uji Konfigurasi Nginx
sudo docker exec mer-web-prod nginx -t

# Reload Konfigurasi Nginx (Tanpa Downtime)
sudo docker exec mer-web-prod nginx -s reload
```
