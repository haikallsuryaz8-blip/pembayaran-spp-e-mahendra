@extends('layouts.app')

@section('title', 'Generate Laporan Pembayaran SPP')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Generate Laporan Pembayaran SPP</h1>
        <p class="text-xs text-slate-400">Filter dan cetak rekapitulasi data pembayaran SPP siswa</p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <form action="{{ route('laporan.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase">Mulai Tanggal</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5 uppercase">Pilih Kelas</label>
                    <select name="id_kelas" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}" {{ request('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} ({{ $k->kompetensi_keahlian }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Action Buttons Bar -->
            <div class="pt-2 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
                <span class="text-xs text-slate-400">Gunakan filter untuk membatasi data yang ingin diekspor</span>
                <div class="flex items-center space-x-2.5 w-full sm:w-auto">
                    <button type="submit" class="flex-1 sm:flex-none bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm shadow transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter Data</span>
                    </button>
                    <a href="{{ route('laporan.cetak', request()->all()) }}" target="_blank"
                       class="flex-1 sm:flex-none bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm shadow transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-file-pdf"></i>
                        <span>Cetak PDF</span>
                    </a>
                    <a href="{{ route('laporan.excel', request()->all()) }}"
                       class="flex-1 sm:flex-none bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-5 rounded-xl text-sm shadow transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-file-excel"></i>
                        <span>Export Excel</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Ringkasan Hasil Filter -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Transaksi Ditemukan</span>
            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ count($pembayaran) }} Transaksi</h3>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Penerimaan Dana</span>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalBayar, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Table Laporan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">No</th>
                        <th class="py-3.5 px-4 font-semibold">Tanggal Bayar</th>
                        <th class="py-3.5 px-4 font-semibold">NISN & Nama Siswa</th>
                        <th class="py-3.5 px-4 font-semibold">Kelas</th>
                        <th class="py-3.5 px-4 font-semibold">Bulan Dibayar</th>
                        <th class="py-3.5 px-4 font-semibold">Petugas Penerima</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pembayaran as $idx => $p)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3 px-4 text-xs text-slate-400">{{ $idx + 1 }}</td>
                            <td class="py-3 px-4 text-xs text-slate-500">{{ date('d/m/Y', strtotime($p->tgl_bayar)) }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-800">
                                <div>{{ $p->siswa->nama ?? 'Siswa Terhapus' }}</div>
                                <div class="text-xs text-slate-400">NISN: {{ $p->nisn }}</div>
                            </td>
                            <td class="py-3 px-4 text-xs text-slate-600">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-3 px-4 text-xs font-medium text-indigo-700">{{ $p->bulan_dibayar }} {{ $p->tahun_dibayar }}</td>
                            <td class="py-3 px-4 text-xs text-slate-500">{{ $p->petugas->nama_petugas ?? 'Petugas' }}</td>
                            <td class="py-3 px-4 text-right font-bold text-emerald-600">
                                Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data transaksi pembayaran sesuai filter yang dipilih</td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($pembayaran) > 0)
                    <tfoot>
                        <tr class="bg-slate-50/80 font-bold text-slate-800 border-t border-slate-200">
                            <td colspan="6" class="py-3.5 px-4 text-right uppercase text-xs">Total Pembayaran:</td>
                            <td class="py-3.5 px-4 text-right text-emerald-700">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
