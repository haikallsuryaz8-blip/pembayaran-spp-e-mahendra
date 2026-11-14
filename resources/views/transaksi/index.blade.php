@extends('layouts.app')

@section('title', 'Entri Transaksi Pembayaran SPP')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Entri Pembayaran SPP</h1>
        <p class="text-xs text-slate-400">Cari siswa berdasarkan NISN atau NIS untuk melakukan pembayaran</p>
    </div>

    <!-- Form Pencarian Siswa -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <form action="{{ route('transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="nisn" value="{{ request('nisn') }}" required
                       placeholder="Ketik NISN atau NIS siswa (Contoh: 0108879256 atau 12460)..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl text-sm shadow transition flex items-center justify-center space-x-2">
                <span>Cari Siswa</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>

    @if(request()->filled('nisn') && !$siswa)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 p-6 rounded-2xl text-center shadow-sm">
            <i class="fa-solid fa-user-slash text-3xl text-amber-500 mb-2 block"></i>
            <h3 class="font-bold text-base">Siswa Tidak Ditemukan!</h3>
            <p class="text-xs text-amber-700 mt-1">Pastikan NISN atau NIS yang Anda masukkan sudah terdaftar di sistem.</p>
        </div>
    @endif

    @if($siswa)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profil Siswa & Info SPP -->
            <div class="space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                    <div class="flex items-center space-x-3 pb-4 border-b border-slate-100">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">{{ $siswa->nama }}</h3>
                            <p class="text-xs text-slate-400">NISN: {{ $siswa->nisn }} | NIS: {{ $siswa->nis }}</p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2.5 text-xs">
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Kelas</span>
                            <span class="font-semibold text-slate-700">{{ $siswa->kelas->nama_kelas }} ({{ $siswa->kelas->kompetensi_keahlian }})</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Tarif SPP</span>
                            <span class="font-semibold text-slate-700">Tahun {{ $siswa->spp->tahun }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">Nominal Wajib</span>
                            <span class="font-bold text-emerald-600">Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }} / bulan</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-50">
                            <span class="text-slate-400">No. Telepon</span>
                            <span class="font-medium text-slate-700">{{ $siswa->no_telp ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Input Pembayaran -->
                <div class="bg-indigo-50/60 rounded-2xl border border-indigo-100 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center space-x-2">
                        <i class="fa-solid fa-cash-register text-indigo-600"></i>
                        <span>Form Entri Bayar</span>
                    </h3>

                    <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-3.5">
                        @csrf
                        <input type="hidden" name="nisn" value="{{ $siswa->nisn }}">
                        <input type="hidden" name="id_spp" value="{{ $siswa->id_spp }}">

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Tanggal Bayar</label>
                            <input type="date" name="tgl_bayar" value="{{ date('Y-m-d') }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Bulan Bayar</label>
                                <select name="bulan_dibayar" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                    @foreach($bulanList as $bulan)
                                        <option value="{{ $bulan }}" {{ in_array($bulan, $bulanTerbayar) ? 'disabled' : '' }}>
                                            {{ $bulan }} {{ in_array($bulan, $bulanTerbayar) ? '(Lunas)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Tahun Bayar</label>
                                <input type="number" name="tahun_dibayar" value="{{ $siswa->spp->tahun ?? date('Y') }}" required
                                       class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Jumlah Bayar (Rp)</label>
                            <input type="number" name="jumlah_bayar" value="{{ $siswa->spp->nominal }}" required
                                   class="w-full px-3 py-2 rounded-xl border border-slate-300 text-sm font-bold text-emerald-600 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        </div>

                        <button type="submit" class="w-full mt-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow transition text-sm flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-check"></i>
                            <span>Simpan Pembayaran</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kartu Status SPP 12 Bulan & Riwayat -->
            <div class="lg:col-span-2 space-y-5">
                <!-- Status 12 Bulan -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 text-sm mb-4">Status Pembayaran SPP Tahun {{ $siswa->spp->tahun }}</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
                        @foreach($bulanList as $bln)
                            @php $lunas = in_array($bln, $bulanTerbayar); @endphp
                            <div class="p-3 rounded-xl border text-center transition {{ $lunas ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-slate-50 border-slate-200/80 text-slate-500' }}">
                                <div class="text-xs font-bold">{{ $bln }}</div>
                                <div class="mt-1">
                                    @if($lunas)
                                        <span class="inline-flex items-center text-[10px] font-semibold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-full">
                                            <i class="fa-solid fa-check mr-1"></i> LUNAS
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-[10px] font-semibold text-slate-400 bg-slate-200/60 px-2 py-0.5 rounded-full">
                                            BELUM
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tabel Riwayat Pembayaran Siswa Ini -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                    <h3 class="font-bold text-slate-800 text-sm mb-4">Catatan Histori Pembayaran</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider">
                                    <th class="py-2.5 px-2">Tanggal</th>
                                    <th class="py-2.5 px-2">Bulan Dibayar</th>
                                    <th class="py-2.5 px-2">Nominal</th>
                                    <th class="py-2.5 px-2">Petugas Penerima</th>
                                    <th class="py-2.5 px-2 text-right">Kuitansi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($historyPembayaran as $h)
                                    <tr class="hover:bg-slate-50/60 transition">
                                        <td class="py-3 px-2 text-xs text-slate-600">{{ date('d/m/Y', strtotime($h->tgl_bayar)) }}</td>
                                        <td class="py-3 px-2 font-semibold text-slate-800">{{ $h->bulan_dibayar }} {{ $h->tahun_dibayar }}</td>
                                        <td class="py-3 px-2 font-bold text-emerald-600">Rp {{ number_format($h->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td class="py-3 px-2 text-xs text-slate-500">{{ $h->petugas->nama_petugas ?? 'Petugas' }}</td>
                                        <td class="py-3 px-2 text-right">
                                            <a href="{{ route('transaksi.kuitansi', $h->id_pembayaran) }}" target="_blank"
                                               class="p-1.5 rounded-lg bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-600 text-xs transition inline-flex items-center">
                                                <i class="fa-solid fa-print mr-1"></i> Cetak
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-slate-400 text-xs">Belum ada riwayat pembayaran untuk siswa ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
