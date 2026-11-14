@extends('layouts.app')

@section('title', 'History Pembayaran SPP')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">History Pembayaran</h1>
            <p class="text-xs text-slate-400">Seluruh riwayat pembayaran SPP yang tercatat di sistem</p>
        </div>
        <form action="{{ route('transaksi.history') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau NISN..."
                   class="px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">Tanggal</th>
                        <th class="py-3.5 px-4 font-semibold">Siswa & Kelas</th>
                        <th class="py-3.5 px-4 font-semibold">Bulan Dibayar</th>
                        <th class="py-3.5 px-4 font-semibold">Nominal</th>
                        <th class="py-3.5 px-4 font-semibold">Petugas Penerima</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Kuitansi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pembayaran as $p)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 text-xs text-slate-500">{{ date('d M Y', strtotime($p->tgl_bayar)) }}</td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $p->siswa->nama ?? 'Siswa Terhapus' }}</div>
                                <div class="text-xs text-slate-400">NISN: {{ $p->nisn }} | Kelas: {{ $p->siswa->kelas->nama_kelas ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                    {{ $p->bulan_dibayar }} {{ $p->tahun_dibayar }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-emerald-600">
                                Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                <i class="fa-solid fa-user-check text-slate-400 mr-1"></i>
                                {{ $p->petugas->nama_petugas ?? 'Petugas' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('transaksi.kuitansi', $p->id_pembayaran) }}" target="_blank"
                                   class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 text-xs font-semibold transition shadow-sm">
                                    <i class="fa-solid fa-print mr-1.5"></i> Cetak Kuitansi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada riwayat transaksi pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $pembayaran->links() }}
        </div>
    </div>
</div>
@endsection
