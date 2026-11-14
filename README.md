# Pembayaran SPP - E.Mahendra
### Sistem Informasi Manajemen Pembayaran SPP • SMK JAKARTA PUSAT 1
**Tahun Ajaran 2026**

Aplikasi Web Manajemen Pembayaran SPP terpadu yang dirancang untuk kebutuhan Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak (RPL). Dilengkapi dengan manajemen multi-role (Admin, Petugas Kasir, Siswa), tracking pembayaran 12 bulan otomatis, cetak kuitansi thermal resmi format dual tanda tangan, rekapitulasi laporan, serta ekspor PDF dan Microsoft Excel.

---

## 👨‍🎓 Identitas Pengembang
- **Nama Siswa**: Haikal Suryadarmansyah
- **NIS**: 12460
- **NISN**: 0108879256
- **Kelas**: XII RPL (Rekayasa Perangkat Lunak)
- **Sekolah**: SMK JAKARTA PUSAT 1

---

## 🏛️ Struktur Tarif SPP (SMK JAKARTA PUSAT 1)
Tahun Ajaran 2026 (Semua tarif di atas Rp 400.000):
| No | Jurusan | Nominal Per Bulan | Keterangan |
|---|---|---|---|
| 1 | **RPL** (Rekayasa Perangkat Lunak) | **Rp 600.000** | Tarif Tertinggi |
| 2 | **AK** (Akuntansi) | **Rp 500.000** | Standard |
| 3 | **MP** (Manajemen Perkantoran) | **Rp 450.000** | Standard |
| 4 | **BR** (Bisnis Retail) | **Rp 420.000** | Standard |

---

## 🚀 Fitur Unggulan
1. **Multi-Guard Authentication**:
   - **Administrator**: Akses penuh kelola Petugas, Siswa, SPP, Kelas, Entri Transaksi, dan Laporan.
   - **Petugas (Kasir TU)**: Akses entri transaksi pembayaran SPP dan cetak kuitansi.
   - **Siswa (Portal Mandiri)**: Akses monitoring tagihan, sisa tunggakan, dan matriks lunas 12 bulan secara mandiri.
2. **Matrix Pembayaran 12 Bulan**:
   - Tracking visual bulan Juli 2026 s/d Juni 2027.
   - Pengecekan status real-time (*Lunas* vs *Belum Bayar*).
3. **Cetak Bukti Pembayaran**:
   - Kuitansi thermal resmi format dual tanda tangan (Tanda Tangan Kasir TU & Siswa).
4. **Rekapitulasi & Export**:
   - Filter laporan berdasarkan rentang tanggal, kelas, dan status.
   - Cetak langsung dan Export ke format Microsoft Excel (`.xls`).
5. **Modern Responsive UI**:
   - Tailwind CSS, FontAwesome 6, Plus Jakarta Sans, dan Chart.js.

---

## 🔑 Akun Default untuk Pengujian

### 1. Administrator
- **Username**: `admin`
- **Password**: `password` / `admin123`

### 2. Petugas (Kasir TU)
- **Username**: `petugas`
- **Password**: `password` / `petugas123`

### 3. Siswa (Portal Siswa)
- **NISN**: `0108879256` (Haikal Suryadarmansyah - XII RPL)
- **Password**: `0108879256` (atau NIS: `12460`)

---

## 🛠️ Instalasi & Menjalankan Lokal

```bash
# Clone repository
git clone https://github.com/haikallsuryaz8-blip/pembayaran-spp-e-mahendra.git
cd pembayaran-spp-e-mahendra

# Install dependencies
composer install
npm install && npm run build

# Setup Environment
cp .env.example .env
php artisan key:generate

# Migrasi & Seeder Database
php artisan migrate:fresh --seed

# Jalankan Local Server
php artisan serve
```

---

## 🌐 Deploy Cloud (Railway / Render / Docker)
Aplikasi ini sudah dilengkapi dengan `Dockerfile`, `Procfile`, dan `docker-entrypoint.sh` yang siap dideploy 24/7 di cloud hosting gratis seperti **Railway.app** atau **Render.com**.

Dukungan database:
- **MySQL / TiDB Serverless** (Rekomendasi Production)
- **SQLite** (Zero-configuration mode)

© 2026 **Pembayaran SPP - E.Mahendra** • SMK JAKARTA PUSAT 1
