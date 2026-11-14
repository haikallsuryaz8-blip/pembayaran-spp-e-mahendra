<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();

        $query = Pembayaran::with(['siswa.kelas', 'petugas', 'spp']);

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_bayar', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }

        $pembayaran = $query->orderBy('tgl_bayar', 'desc')->get();
        $totalBayar = $pembayaran->sum('jumlah_bayar');

        return view('admin.laporan.index', compact('pembayaran', 'kelas', 'totalBayar'));
    }

    public function cetak(Request $request)
    {
        $query = Pembayaran::with(['siswa.kelas', 'petugas', 'spp']);

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_bayar', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }

        $pembayaran = $query->orderBy('tgl_bayar', 'desc')->get();
        $totalBayar = $pembayaran->sum('jumlah_bayar');

        return view('admin.laporan.cetak', compact('pembayaran', 'totalBayar'));
    }

    public function exportExcel(Request $request)
    {
        $query = Pembayaran::with(['siswa.kelas', 'petugas', 'spp']);

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_bayar', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('id_kelas', $request->id_kelas);
            });
        }

        $pembayaran = $query->orderBy('tgl_bayar', 'desc')->get();
        $totalBayar = $pembayaran->sum('jumlah_bayar');

        $filename = 'Laporan_Pembayaran_SPP_' . date('Ymd_His') . '.xls';

        return response()->view('admin.laporan.excel', compact('pembayaran', 'totalBayar'), 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
