@extends('layouts.app')

@section('title', 'Portal Riwayat Pembayaran SPP')

@section('content')
<div class="space-y-6">

    <!-- Header Profil Siswa -->
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-3xl text-indigo-300 shadow-inner flex-shrink-0">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <span class="inline-block bg-indigo-500/40 text-indigo-200 border border-indigo-400/30 px-3 py-0.5 rounded-full text-xs font-semibold tracking-wider uppercase mb-1">
                        Portal Siswa Resmi
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold">{{ $siswa->nama }}</h1>
                    <p class="text-indigo-200 text-xs sm:text-sm mt-1 flex flex-wrap gap-x-4 gap-y-1">
                        <span><i class="fa-solid fa-id-card mr-1 text-indigo-400"></i> NISN: <strong>{{ $siswa->nisn }}</strong></span>
                        <span><i class="fa-solid fa-hashtag mr-1 text-indigo-400"></i> NIS: <strong>{{ $siswa->nis }}</strong></span>
                        <span><i class="fa-solid fa-school mr-1 text-indigo-400"></i> Kelas: <strong>{{ $siswa->kelas->nama_kelas }} ({{ $siswa->kelas->kompetensi_keahlian }})</strong></span>
                    </p>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 text-left md:text-right flex-shrink-0">
                <span class="text-xs text-indigo-200 block font-medium">Tahun Ajaran Aktif</span>
                <span class="text-xl font-bold text-white block mt-0.5">Tahun {{ $siswa->spp->tahun }}</span>
                <span class="text-xs text-indigo-300 block">SMK JAKARTA PUSAT 1</span>
            </div>
        </div>
    </div>

    <!-- 3 Metric Cards Finansial SPP -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Tarif SPP Per Bulan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tarif Wajib SPP</p>
                <h3 class="text-xl font-bold text-slate-800 mt-1">Rp {{ number_format($siswa->spp->nominal, 0, ',', '.') }}</h3>
                <span class="text-xs text-indigo-600 font-medium">Per Bulan</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
        </div>

        <!-- Total Terbayar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Sudah Dibayar</p>
                <h3 class="text-xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</h3>
                <span class="text-xs text-emerald-700 font-medium bg-emerald-50 px-2 py-0.5 rounded-full">
                    {{ $totalBulanLunas }} dari 12 Bulan Lunas
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <!-- Sisa Tunggakan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sisa Tagihan SPP</p>
                <h3 class="text-xl font-bold text-rose-600 mt-1">Rp {{ number_format($totalSisaTunggakan, 0, ',', '.') }}</h3>
                <span class="text-xs text-rose-700 font-medium bg-rose-50 px-2 py-0.5 rounded-full">
                    {{ $sisaBulanTunggakan }} Bulan Belum Dibayar
                </span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
        </div>
    </div>

    <!-- Status 12 Bulan Visual Matrix -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Matriks Status Pembayaran 12 Bulan</h3>
                <p class="text-xs text-slate-400">Pantau status pelunasan iuran SPP Anda dari bulan Januari hingga Desember</p>
            </div>
            <span class="text-xs bg-slate-100 text-slate-600 px-3 py-1 rounded-full font-semibold">
                Tahun {{ $siswa->spp->tahun }}
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3.5">
            @foreach($bulanList as $bln)
                @php 
                    $isLunas = in_array($bln, $bulanTerbayar);
                    $dataBayar = $pembayaranPerBulan[$bln] ?? null;
                @endphp
                <div class="p-3.5 rounded-2xl border transition relative {{ $isLunas ? 'bg-emerald-50/70 border-emerald-200 shadow-sm' : 'bg-slate-50 border-slate-200/70' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-700">{{ $bln }}</span>
                        @if($isLunas)
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                        @else
                            <i class="fa-regular fa-clock text-slate-300 text-xs"></i>
                        @endif
                    </div>

                    <div class="mt-3">
                        @if($isLunas)
                            <span class="inline-block text-[10px] font-bold text-emerald-800 bg-emerald-100/90 px-2 py-0.5 rounded-full">
                                LUNAS
                            </span>
                            <div class="text-[10px] text-slate-400 mt-1.5">
                                {{ date('d/m/Y', strtotime($dataBayar->tgl_bayar)) }}
                            </div>
                        @else
                            <span class="inline-block text-[10px] font-semibold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100">
                                BELUM DIBAYAR
                            </span>
                            <div class="text-[10px] text-slate-400 mt-1.5">
                                Tagihan Aktif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tabel Riwayat Pembayaran (Read-Only Tanpa Tombol Cetak) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-5">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Riwayat Transaksi Pembayaran</h3>
                <p class="text-xs text-slate-400">Daftar pembayaran resmi yang telah diverifikasi dan diterima oleh loket TU</p>
            </div>
            <div class="text-xs text-slate-500 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-xl flex items-center space-x-1.5">
                <i class="fa-solid fa-circle-info text-indigo-500"></i>
                <span>Kuitansi fisik resmi dapat diminta langsung ke Petugas TU</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3 px-4 font-semibold">No</th>
                        <th class="py-3 px-4 font-semibold">Tanggal Bayar</th>
                        <th class="py-3 px-4 font-semibold">Bulan & Tahun SPP</th>
                        <th class="py-3 px-4 font-semibold">Nominal Pembayaran</th>
                        <th class="py-3 px-4 font-semibold">Petugas Penerima</th>
                        <th class="py-3 px-4 font-semibold text-right">Status Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($historyPembayaran as $idx => $h)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 text-xs text-slate-400">{{ $idx + 1 }}</td>
                            <td class="py-3.5 px-4 text-xs text-slate-600 font-medium">
                                <i class="fa-regular fa-calendar mr-1.5 text-slate-400"></i>
                                {{ date('d F Y', strtotime($h->tgl_bayar)) }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                                    {{ $h->bulan_dibayar }} {{ $h->tahun_dibayar }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-emerald-600">
                                Rp {{ number_format($h->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                <i class="fa-solid fa-user-check text-indigo-400 mr-1.5"></i>
                                {{ $h->petugas->nama_petugas ?? 'Petugas TU' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <i class="fa-solid fa-check-double mr-1.5 text-emerald-500 text-[10px]"></i>
                                    Sah & Terverifikasi
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400 text-sm">
                                <i class="fa-solid fa-inbox text-4xl mb-2 block text-slate-300"></i>
                                Belum ada riwayat transaksi pembayaran SPP yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Catatan Edukatif untuk Siswa / Wali Murid -->
    <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-5 text-amber-900 flex items-start space-x-3.5">
        <i class="fa-solid fa-circle-exclamation text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
        <div class="text-xs leading-relaxed">
            <h4 class="font-bold text-sm text-amber-950 mb-0.5">Informasi Pembayaran SPP SMK Jakarta Pusat 1:</h4>
            <p>
                Pembayaran SPP wajib diselesaikan paling lambat tanggal 10 setiap bulannya. Untuk melakukan pembayaran tunai atau meminta slip kuitansi fisik bertanda tangan dan cap basah, silakan kunjungi loket Tata Usaha (TU) dengan menunjukkan NISN Anda.
            </p>
        </div>
    </div>

</div>
@endsection
