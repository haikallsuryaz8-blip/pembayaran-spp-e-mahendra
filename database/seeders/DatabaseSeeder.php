<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Kelas;
use App\Models\Spp;
use App\Models\Petugas;
use App\Models\Siswa;
use App\Models\Pembayaran;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan Data Lama
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Pembayaran::truncate();
        Siswa::truncate();
        Spp::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Buat Tarif SPP Tahun 2026 Semua di Atas 400k (RPL Kasta Sultan 600k!)
        $sppRpl = Spp::create(['tahun' => 2026, 'nominal' => 600000]); // RPL: Rp 600.000
        $sppAk  = Spp::create(['tahun' => 2026, 'nominal' => 500000]); // AK:  Rp 500.000
        $sppMp  = Spp::create(['tahun' => 2026, 'nominal' => 450000]); // MP:  Rp 450.000
        $sppBr  = Spp::create(['tahun' => 2026, 'nominal' => 420000]); // BR:  Rp 420.000

        // 3. Seed Master Kelas (4 Jurusan dari Kelas X s/d XII)
        $daftarKelas = [
            // RPL
            'X RPL' => Kelas::updateOrCreate(['nama_kelas' => 'X RPL'], ['kompetensi_keahlian' => 'Rekayasa Perangkat Lunak']),
            'XI RPL' => Kelas::updateOrCreate(['nama_kelas' => 'XI RPL'], ['kompetensi_keahlian' => 'Rekayasa Perangkat Lunak']),
            'XII RPL' => Kelas::updateOrCreate(['nama_kelas' => 'XII RPL'], ['kompetensi_keahlian' => 'Rekayasa Perangkat Lunak']),
            // Bisnis Retail (BR)
            'X BR' => Kelas::updateOrCreate(['nama_kelas' => 'X BR'], ['kompetensi_keahlian' => 'Bisnis Retail']),
            'XI BR' => Kelas::updateOrCreate(['nama_kelas' => 'XI BR'], ['kompetensi_keahlian' => 'Bisnis Retail']),
            'XII BR' => Kelas::updateOrCreate(['nama_kelas' => 'XII BR'], ['kompetensi_keahlian' => 'Bisnis Retail']),
            // Manajemen Perkantoran (MP)
            'X MP' => Kelas::updateOrCreate(['nama_kelas' => 'X MP'], ['kompetensi_keahlian' => 'Manajemen Perkantoran']),
            'XI MP' => Kelas::updateOrCreate(['nama_kelas' => 'XI MP'], ['kompetensi_keahlian' => 'Manajemen Perkantoran']),
            'XII MP' => Kelas::updateOrCreate(['nama_kelas' => 'XII MP'], ['kompetensi_keahlian' => 'Manajemen Perkantoran']),
            // Akuntansi (AK)
            'X AK' => Kelas::updateOrCreate(['nama_kelas' => 'X AK'], ['kompetensi_keahlian' => 'Akuntansi']),
            'XI AK' => Kelas::updateOrCreate(['nama_kelas' => 'XI AK'], ['kompetensi_keahlian' => 'Akuntansi']),
            'XII AK' => Kelas::updateOrCreate(['nama_kelas' => 'XII AK'], ['kompetensi_keahlian' => 'Akuntansi']),
        ];

        // 4. Seed Petugas (Admin & Kasir TU)
        $admin = Petugas::updateOrCreate(['username' => 'admin'], [
            'password' => Hash::make('admin123'),
            'nama_petugas' => 'Haikal Administrator',
            'level' => 'admin',
        ]);

        $petugas = Petugas::updateOrCreate(['username' => 'petugas'], [
            'password' => Hash::make('petugas123'),
            'nama_petugas' => 'Staff TU Kasir',
            'level' => 'petugas',
        ]);

        // 5. Data Siswa
        // A. RPL (Teman sekelas Haikal -> SPP Rp 600.000)
        $siswaRplX = [
            ['nis' => '13101', 'nisn' => '0112450001', 'nama' => 'ADHAM SANJAYA'],
            ['nis' => '13102', 'nisn' => '0112450002', 'nama' => 'AIRA MOUDI IBRAHIM'],
            ['nis' => '13103', 'nisn' => '0112450003', 'nama' => 'AJI IRAWAN'],
            ['nis' => '13104', 'nisn' => '0112450004', 'nama' => 'ALHIKAM FATHUL MUBIN'],
            ['nis' => '13105', 'nisn' => '0112450005', 'nama' => 'ANANTA ANBIYA DWIPRAMA'],
        ];

        $siswaRplXI = [
            ['nis' => '12701', 'nisn' => '0105670001', 'nama' => 'FADIL ADITYA DERMAWAN'],
            ['nis' => '12702', 'nisn' => '0105670002', 'nama' => 'FAREL AHMAD RIZKI'],
            ['nis' => '12703', 'nisn' => '0105670003', 'nama' => 'HABIB SUFYAN'],
            ['nis' => '12704', 'nisn' => '0105670004', 'nama' => 'JASIR FAHLERY'],
            ['nis' => '12705', 'nisn' => '0105670005', 'nama' => 'JULIANTO DHARMAWAN'],
        ];

        $siswaRplXII = [
            ['nis' => '12460', 'nisn' => '0108879256', 'nama' => 'HAIKAL SURYADARMANSYAH'], // Akun Utama
            ['nis' => '12452', 'nisn' => '0109968109', 'nama' => 'AZZALEA DWINA SYATIFA'],
            ['nis' => '12454', 'nisn' => '0104649021', 'nama' => 'BREYKA RODOI MIKHAEL'],
            ['nis' => '12476', 'nisn' => '3108646214', 'nama' => 'RAIHAN FARIS SAPUTRA'],
            ['nis' => '12481', 'nisn' => '0102788917', 'nama' => 'ZAMIR QOBUS TABARAK'],
        ];

        // B. Bisnis Retail (BR -> SPP Rp 420.000)
        $siswaBrX = [
            ['nis' => '13201', 'nisn' => '0113010001', 'nama' => 'BAGAS SATRIA PRATAMA'],
            ['nis' => '13202', 'nisn' => '0113010002', 'nama' => 'CANTIKA DEWI LESTARI'],
            ['nis' => '13203', 'nisn' => '0113010003', 'nama' => 'DION PURNAMA AJI'],
            ['nis' => '13204', 'nisn' => '0113010004', 'nama' => 'ELVIRA MAHARANI'],
            ['nis' => '13205', 'nisn' => '0113010005', 'nama' => 'FARHAN RAMADHAN'],
        ];

        $siswaBrXI = [
            ['nis' => '12801', 'nisn' => '0104010001', 'nama' => 'GILANG MAULANA IBRAHIM'],
            ['nis' => '12802', 'nisn' => '0104010002', 'nama' => 'HANIFAH NUR AINI'],
            ['nis' => '12803', 'nisn' => '0104010003', 'nama' => 'INDRA KUSUMA WIJAYA'],
            ['nis' => '12804', 'nisn' => '0104010004', 'nama' => 'JESSICA AMALIA PUTRI'],
            ['nis' => '12805', 'nisn' => '0104010005', 'nama' => 'KEVIN ARDIANSYAH'],
        ];

        $siswaBrXII = [
            ['nis' => '12501', 'nisn' => '0095010001', 'nama' => 'LUTHFI HAKIM SANTOSO'],
            ['nis' => '12502', 'nisn' => '0095010002', 'nama' => 'MUTIARA KHAIRUNNISA'],
            ['nis' => '12503', 'nisn' => '0095010003', 'nama' => 'NABIL FACHREZI'],
            ['nis' => '12504', 'nisn' => '0095010004', 'nama' => 'OLIVIA CLARISSA'],
            ['nis' => '12505', 'nisn' => '0095010005', 'nama' => 'PANDU SETIAWAN'],
        ];

        // C. Manajemen Perkantoran (MP -> SPP Rp 450.000)
        $siswaMpX = [
            ['nis' => '13301', 'nisn' => '0114010001', 'nama' => 'QISTHI AULIA RAHMAN'],
            ['nis' => '13302', 'nisn' => '0114010002', 'nama' => 'RATNA SARI DEWI'],
            ['nis' => '13303', 'nisn' => '0114010003', 'nama' => 'SURYA ADITYA NUGRAHA'],
            ['nis' => '13304', 'nisn' => '0114010004', 'nama' => 'TIARA NURUL IZZAH'],
            ['nis' => '13305', 'nisn' => '0114010005', 'nama' => 'UTAMA BUDI PRASETYO'],
        ];

        $siswaMpXI = [
            ['nis' => '12901', 'nisn' => '0105010001', 'nama' => 'VALENTINO RADITYA'],
            ['nis' => '12902', 'nisn' => '0105010002', 'nama' => 'WIDYA PUSPITA ANGGRAENI'],
            ['nis' => '12903', 'nisn' => '0105010003', 'nama' => 'XAVIER RIZQULLAH'],
            ['nis' => '12904', 'nisn' => '0105010004', 'nama' => 'YULIANA CITRA LESTARI'],
            ['nis' => '12905', 'nisn' => '0105010005', 'nama' => 'ZULFA KHOIRUNNISA'],
        ];

        $siswaMpXII = [
            ['nis' => '12601', 'nisn' => '0096010001', 'nama' => 'ANGGA DWI KURNIAWAN'],
            ['nis' => '12602', 'nisn' => '0096010002', 'nama' => 'BELLA ANGGRAINI'],
            ['nis' => '12603', 'nisn' => '0096010003', 'nama' => 'CHANDRA EKA PUTRA'],
            ['nis' => '12604', 'nisn' => '0096010004', 'nama' => 'DARA PUSPITA SARI'],
            ['nis' => '12605', 'nisn' => '0096010005', 'nama' => 'ERIK FEBRIANTO'],
        ];

        // D. Akuntansi (AK -> SPP Rp 500.000)
        $siswaAkX = [
            ['nis' => '13401', 'nisn' => '0115010001', 'nama' => 'FIRA ANGGRAENI'],
            ['nis' => '13402', 'nisn' => '0115010002', 'nama' => 'GALIH PRAKOSO'],
            ['nis' => '13403', 'nisn' => '0115010003', 'nama' => 'HANA SYAFIRA'],
            ['nis' => '13404', 'nisn' => '0115010004', 'nama' => 'ILHAM MAULANA'],
            ['nis' => '13405', 'nisn' => '0115010005', 'nama' => 'JAUZA NUR AMALIA'],
        ];

        $siswaAkXI = [
            ['nis' => '13001', 'nisn' => '0106010001', 'nama' => 'KHARISMA WULANDARI'],
            ['nis' => '13002', 'nisn' => '0106010002', 'nama' => 'LUKMAN HIDAYAT'],
            ['nis' => '13003', 'nisn' => '0106010003', 'nama' => 'MAYA ALICIA'],
            ['nis' => '13004', 'nisn' => '0106010004', 'nama' => 'NAUFAL GHANI'],
            ['nis' => '13005', 'nisn' => '0106010005', 'nama' => 'OKTAVIA RAMADHANI'],
        ];

        $siswaAkXII = [
            ['nis' => '12651', 'nisn' => '0097010001', 'nama' => 'PUTRA ADITYA NUGROHO'],
            ['nis' => '12652', 'nisn' => '0097010002', 'nama' => 'QONITA AZZAHRA'],
            ['nis' => '12653', 'nisn' => '0097010003', 'nama' => 'RENDY SAPUTRA'],
            ['nis' => '12654', 'nisn' => '0097010004', 'nama' => 'SHEILA MARCELLA'],
            ['nis' => '12655', 'nisn' => '0097010005', 'nama' => 'TAUFIQ HIDAYATULLAH'],
        ];

        // Hubungkan Siswa dengan SPP Jurusannya Masing-Masing
        $grupSiswa = [
            // RPL -> Rp 600.000
            ['data' => $siswaRplX, 'kelas' => $daftarKelas['X RPL'], 'spp' => $sppRpl],
            ['data' => $siswaRplXI, 'kelas' => $daftarKelas['XI RPL'], 'spp' => $sppRpl],
            ['data' => $siswaRplXII, 'kelas' => $daftarKelas['XII RPL'], 'spp' => $sppRpl],

            // AK -> Rp 500.000
            ['data' => $siswaAkX, 'kelas' => $daftarKelas['X AK'], 'spp' => $sppAk],
            ['data' => $siswaAkXI, 'kelas' => $daftarKelas['XI AK'], 'spp' => $sppAk],
            ['data' => $siswaAkXII, 'kelas' => $daftarKelas['XII AK'], 'spp' => $sppAk],

            // MP -> Rp 450.000
            ['data' => $siswaMpX, 'kelas' => $daftarKelas['X MP'], 'spp' => $sppMp],
            ['data' => $siswaMpXI, 'kelas' => $daftarKelas['XI MP'], 'spp' => $sppMp],
            ['data' => $siswaMpXII, 'kelas' => $daftarKelas['XII MP'], 'spp' => $sppMp],

            // BR -> Rp 420.000
            ['data' => $siswaBrX, 'kelas' => $daftarKelas['X BR'], 'spp' => $sppBr],
            ['data' => $siswaBrXI, 'kelas' => $daftarKelas['XI BR'], 'spp' => $sppBr],
            ['data' => $siswaBrXII, 'kelas' => $daftarKelas['XII BR'], 'spp' => $sppBr],
        ];

        foreach ($grupSiswa as $grup) {
            foreach ($grup['data'] as $s) {
                Siswa::create([
                    'nisn' => $s['nisn'],
                    'nis' => $s['nis'],
                    'nama' => $s['nama'],
                    'id_kelas' => $grup['kelas']->id_kelas,
                    'alamat' => 'Jakarta Pusat',
                    'no_telp' => '0812' . rand(10000000, 99999999),
                    'id_spp' => $grup['spp']->id_spp,
                    'password' => Hash::make($s['nis']),
                ]);
            }
        }

        // 6. Buatkan Contoh Transaksi Riil Pembayaran Siswa
        // RPL: Haikal (Rp 600.000)
        Pembayaran::create([
            'id_petugas' => $admin->id_petugas,
            'nisn' => '0108879256',
            'tgl_bayar' => '2026-01-10',
            'bulan_dibayar' => 'Januari',
            'tahun_dibayar' => '2026',
            'id_spp' => $sppRpl->id_spp,
            'jumlah_bayar' => $sppRpl->nominal,
        ]);

        Pembayaran::create([
            'id_petugas' => $petugas->id_petugas,
            'nisn' => '0108879256',
            'tgl_bayar' => '2026-02-09',
            'bulan_dibayar' => 'Februari',
            'tahun_dibayar' => '2026',
            'id_spp' => $sppRpl->id_spp,
            'jumlah_bayar' => $sppRpl->nominal,
        ]);

        // AK: Fira Anggraeni (Rp 500.000)
        Pembayaran::create([
            'id_petugas' => $petugas->id_petugas,
            'nisn' => '0115010001',
            'tgl_bayar' => '2026-01-12',
            'bulan_dibayar' => 'Januari',
            'tahun_dibayar' => '2026',
            'id_spp' => $sppAk->id_spp,
            'jumlah_bayar' => $sppAk->nominal,
        ]);

        Pembayaran::create([
            'id_petugas' => $admin->id_petugas,
            'nisn' => '0115010001',
            'tgl_bayar' => '2026-02-11',
            'bulan_dibayar' => 'Februari',
            'tahun_dibayar' => '2026',
            'id_spp' => $sppAk->id_spp,
            'jumlah_bayar' => $sppAk->nominal,
        ]);

        // MP: Qisthi Aulia (Rp 450.000)
        Pembayaran::create([
            'id_petugas' => $petugas->id_petugas,
            'nisn' => '0114010001',
            'tgl_bayar' => '2026-01-14',
            'bulan_dibayar' => 'Januari',
            'tahun_dibayar' => '2026',
            'id_spp' => $sppMp->id_spp,
            'jumlah_bayar' => $sppMp->nominal,
        ]);

        // BR: Hanifah Nur (Rp 420.000)
        Pembayaran::create([
            'id_petugas' => $admin->id_petugas,
            'nisn' => '0104010002',
            'tgl_bayar' => '2026-01-15',
            'bulan_dibayar' => 'Januari',
            'tahun_dibayar' => '2026',
            'id_spp' => $sppBr->id_spp,
            'jumlah_bayar' => $sppBr->nominal,
        ]);
    }
}
