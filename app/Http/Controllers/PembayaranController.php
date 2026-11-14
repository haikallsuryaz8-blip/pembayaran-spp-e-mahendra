<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $bulanList = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $siswa = null;
        $historyPembayaran = collect();
        $bulanTerbayar = [];

        if ($request->filled('nisn')) {
            $siswa = Siswa::with(['kelas', 'spp'])->where('nisn', $request->nisn)->orWhere('nis', $request->nisn)->first();

            if ($siswa) {
                $historyPembayaran = Pembayaran::with('petugas')
                    ->where('nisn', $siswa->nisn)
                    ->orderBy('tgl_bayar', 'desc')
                    ->get();

                $bulanTerbayar = Pembayaran::where('nisn', $siswa->nisn)
                    ->pluck('bulan_dibayar')
                    ->toArray();
            }
        }

        return view('transaksi.index', compact('siswa', 'historyPembayaran', 'bulanList', 'bulanTerbayar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:siswa,nisn',
            'tgl_bayar' => 'required|date',
            'bulan_dibayar' => 'required',
            'tahun_dibayar' => 'required|digits:4',
            'id_spp' => 'required|exists:spp,id_spp',
            'jumlah_bayar' => 'required|numeric',
        ]);

        // Cek apakah bulan dan tahun tersebut sudah pernah dibayar oleh siswa ini
        $sudahBayar = Pembayaran::where('nisn', $request->nisn)
            ->where('bulan_dibayar', $request->bulan_dibayar)
            ->where('tahun_dibayar', $request->tahun_dibayar)
            ->exists();

        if ($sudahBayar) {
            return back()->with('error', "SPP bulan {$request->bulan_dibayar} {$request->tahun_dibayar} sudah pernah dibayar!");
        }

        Pembayaran::create([
            'id_petugas' => Auth::guard('petugas')->id(),
            'nisn' => $request->nisn,
            'tgl_bayar' => $request->tgl_bayar,
            'bulan_dibayar' => $request->bulan_dibayar,
            'tahun_dibayar' => $request->tahun_dibayar,
            'id_spp' => $request->id_spp,
            'jumlah_bayar' => $request->jumlah_bayar,
        ]);

        return redirect()->route('transaksi.index', ['nisn' => $request->nisn])
            ->with('success', "Pembayaran SPP bulan {$request->bulan_dibayar} {$request->tahun_dibayar} berhasil disimpan!");
    }

    public function history(Request $request)
    {
        $pembayaran = Pembayaran::with(['siswa.kelas', 'petugas', 'spp'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->whereHas('siswa', function ($q) use ($request) {
                    $q->where('nama', 'like', "%{$request->q}%")
                      ->orWhere('nisn', 'like', "%{$request->q}%");
                });
            })
            ->latest('tgl_bayar')
            ->paginate(15);

        return view('transaksi.history', compact('pembayaran'));
    }

    public function cetakKuitansi($id)
    {
        $pembayaran = Pembayaran::with(['siswa.kelas', 'petugas', 'spp'])->findOrFail($id);

        // Jika yang login adalah siswa, pastikan kuitansi yang dibuka adalah miliknya sendiri (keamanan privasi)
        if (Auth::guard('siswa')->check()) {
            if ($pembayaran->nisn !== Auth::guard('siswa')->user()->nisn) {
                return back()->with('error', 'Anda tidak berhak melihat kuitansi siswa lain!');
            }
        }

        return view('transaksi.kuitansi', compact('pembayaran'));
    }
}
