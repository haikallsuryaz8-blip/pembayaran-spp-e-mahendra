<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class SiswaPortalController extends Controller
{
    public function history()
    {
        $siswa = Auth::guard('siswa')->user()->load(['kelas', 'spp']);

        $historyPembayaran = Pembayaran::with('petugas')
            ->where('nisn', $siswa->nisn)
            ->orderBy('tgl_bayar', 'desc')
            ->get();

        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ambil data pembayaran berdasarkan bulan
        $pembayaranPerBulan = Pembayaran::where('nisn', $siswa->nisn)
            ->get()
            ->keyBy('bulan_dibayar');

        $bulanTerbayar = $pembayaranPerBulan->keys()->toArray();

        // Kalkulasi Statistik Finansial Siswa
        $nominalSpp = $siswa->spp->nominal ?? 0;
        $totalBulanLunas = count($bulanTerbayar);
        $totalTerbayar = $totalBulanLunas * $nominalSpp;
        $sisaBulanTunggakan = 12 - $totalBulanLunas;
        $totalSisaTunggakan = $sisaBulanTunggakan * $nominalSpp;

        return view('siswa.history', compact(
            'siswa',
            'historyPembayaran',
            'bulanList',
            'pembayaranPerBulan',
            'bulanTerbayar',
            'totalBulanLunas',
            'totalTerbayar',
            'sisaBulanTunggakan',
            'totalSisaTunggakan'
        ));
    }
}
