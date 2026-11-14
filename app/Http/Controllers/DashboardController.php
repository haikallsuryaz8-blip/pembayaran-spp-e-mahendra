<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Petugas;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalPetugas = Petugas::count();

        // Total Kas Masuk Seluruh Waktu & Bulan Ini
        $totalKasAllTime = Pembayaran::sum('jumlah_bayar');
        $totalTransaksiBulanIni = Pembayaran::whereMonth('tgl_bayar', date('m'))
            ->whereYear('tgl_bayar', date('Y'))
            ->sum('jumlah_bayar');

        // Transaksi Kasir Terbaru
        $transaksiTerbaru = Pembayaran::with(['siswa.kelas', 'petugas', 'spp'])
            ->latest('id_pembayaran')
            ->take(6)
            ->get();

        // Kas Nyata per Jurusan
        $jurusanStats = [
            'RPL' => Pembayaran::whereHas('siswa.kelas', fn($q) => $q->where('nama_kelas', 'like', '%RPL%'))->sum('jumlah_bayar'),
            'AK'  => Pembayaran::whereHas('siswa.kelas', fn($q) => $q->where('nama_kelas', 'like', '%AK%'))->sum('jumlah_bayar'),
            'MP'  => Pembayaran::whereHas('siswa.kelas', fn($q) => $q->where('nama_kelas', 'like', '%MP%'))->sum('jumlah_bayar'),
            'BR'  => Pembayaran::whereHas('siswa.kelas', fn($q) => $q->where('nama_kelas', 'like', '%BR%'))->sum('jumlah_bayar'),
        ];

        // Hitung Siswa yang sudah pernah melakukan pembayaran
        $siswaSudahBayarCount = Pembayaran::distinct('nisn')->count('nisn');
        $persentasePartisipasi = $totalSiswa > 0 ? round(($siswaSudahBayarCount / $totalSiswa) * 100, 1) : 0;

        // Data Tren Pembayaran Bulanan (Januari s/d Desember)
        $namaBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $trenBulananData = [];
        foreach ($namaBulan as $bln) {
            $totalBln = Pembayaran::where('bulan_dibayar', $bln)->sum('jumlah_bayar');
            $trenBulananData[] = (int) $totalBln;
        }

        return view('dashboard.index', compact(
            'totalSiswa',
            'totalKelas',
            'totalPetugas',
            'totalKasAllTime',
            'totalTransaksiBulanIni',
            'siswaSudahBayarCount',
            'persentasePartisipasi',
            'transaksiTerbaru',
            'jurusanStats',
            'namaBulan',
            'trenBulananData'
        ));
    }
}