@extends('layouts.app')

@section('title', 'Dashboard Admin & Petugas')

@section('content')
<div class="space-y-7">

    <!-- Top Action Bar & Dynamic Greeting (Dribbble FinTech Header) -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-950/20 relative overflow-hidden border border-indigo-500/20">
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-bold border border-white/15 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-indigo-200">Panel Kendali {{ strtoupper(auth('petugas')->user()->level) }}</span>
                    <span class="text-white/40">•</span>
                    <span class="text-emerald-300 font-semibold">Sistem Kasir Aktif</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
                    <span id="dynamicGreeting">Selamat Datang</span>, {{ auth('petugas')->user()->nama_petugas }}! 👋
                </h1>
                <p class="text-xs sm:text-sm text-indigo-200/80 leading-relaxed font-normal">
                    Pusat monitoring keuangan Pembayaran SPP (SMK Jakarta Pusat 1). Pantau arus kas masuk, status pelunasan siswa, dan rekapitulasi 4 jurusan.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('transaksi.index') }}" 
                   class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-4 sm:px-5 py-3 rounded-2xl text-xs sm:text-sm shadow-lg shadow-indigo-600/30 transition-all duration-150 flex items-center space-x-2 active:scale-95 border border-indigo-400/30">
                    <i class="fa-solid fa-plus-circle text-base"></i>
                    <span>Entri Pembayaran</span>
                </a>
                @if(auth('petugas')->user()->level === 'admin')
                    <a href="{{ route('laporan.index') }}" 
                       class="bg-white/10 hover:bg-white/20 text-white font-bold px-4 sm:px-5 py-3 rounded-2xl text-xs sm:text-sm backdrop-blur-md transition-all duration-150 flex items-center space-x-2 border border-white/15">
                        <i class="fa-solid fa-file-invoice-dollar text-indigo-300"></i>
                        <span>Cetak Laporan</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Ambient Background Glows -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-12 -top-12 w-64 h-64 bg-violet-500/15 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 4 FinTech Metric Cards (Bento Modern Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Total Kas Terkumpul (All-Time) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kas Masuk</span>
                <div class="w-11 h-11 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3">
                Rp {{ number_format($totalKasAllTime, 0, ',', '.') }}
            </h3>
            <div class="mt-3 flex items-center justify-between text-xs pt-3 border-t border-slate-100">
                <span class="text-slate-500 font-medium">Bulan Berjalan:</span>
                <span class="font-bold text-indigo-600">Rp {{ number_format($totalTransaksiBulanIni, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Partisipasi Pembayaran Siswa -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Siswa Sudah Bayar</span>
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <div class="flex items-baseline space-x-2 mt-3">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $siswaSudahBayarCount }}</h3>
                <span class="text-xs text-slate-400 font-semibold">/ {{ $totalSiswa }} Siswa</span>
            </div>
            <!-- Progress Bar -->
            <div class="mt-3 pt-3 border-t border-slate-100">
                <div class="flex justify-between text-xs mb-1 font-semibold">
                    <span class="text-slate-500">Tingkat Partisipasi</span>
                    <span class="text-emerald-600">{{ $persentasePartisipasi }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-400 h-full rounded-full transition-all duration-500" style="width: {{ max($persentasePartisipasi, 5) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Rombel & Kelas -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rombel Kelas</span>
                <div class="w-11 h-11 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3">{{ $totalKelas }} Kelas</h3>
            <div class="mt-3 flex items-center space-x-2 text-xs pt-3 border-t border-slate-100 text-slate-500 font-medium">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                <span>Tingkat X, XI, XII (4 Jurusan)</span>
            </div>
        </div>

        <!-- Operator Kasir / TU -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Petugas & Admin</span>
                <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
            </div>
            <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3">{{ $totalPetugas }} Akun</h3>
            <div class="mt-3 flex items-center justify-between text-xs pt-3 border-t border-slate-100 text-slate-500 font-medium">
                <span class="flex items-center space-x-1 text-emerald-600 font-semibold">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>Multi-Guard Aktif</span>
                </span>
                <span class="text-slate-400">Petugas / Siswa</span>
            </div>
        </div>

    </div>

    <!-- Charts & Analytics Section (Dribbble Split Layout) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Wide Chart: Tren Arus Kas Masuk 12 Bulan (Gradient Area Line Chart) -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div>
                    <div class="flex items-center space-x-2">
                        <h3 class="font-extrabold text-slate-900 text-base">Arus Kas Masuk Bulanan</h3>
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                            Tahun 2026
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Grafik akumulasi pembayaran SPP siswa per bulan kalender</p>
                </div>
                <div class="flex items-center space-x-2 text-xs font-semibold text-slate-500 bg-slate-50 p-1.5 rounded-xl border border-slate-100">
                    <span class="px-2.5 py-1 rounded-lg bg-white text-indigo-700 shadow-sm">
                        <i class="fa-solid fa-chart-area mr-1 text-indigo-600"></i> Tren Bulanan
                    </span>
                </div>
            </div>
            <div class="h-64 sm:h-72">
                <canvas id="chartTrenBulanan"></canvas>
            </div>
        </div>

        <!-- Right Chart: Perbandingan Kas Masuk 4 Jurusan -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-base">Kontribusi Kas per Jurusan</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Akumulasi penerimaan SPP</p>
                    </div>
                </div>

                <div class="h-44 flex items-center justify-center my-2">
                    <canvas id="chartKontribusiJurusan"></canvas>
                </div>
            </div>

            <!-- List Progress Breakdown Jurusan -->
            <div class="space-y-3 pt-4 border-t border-slate-100">
                <!-- RPL -->
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span class="flex items-center space-x-1.5 text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                            <span>RPL (Rp 600.000 / bln)</span>
                        </span>
                        <span class="font-extrabold text-slate-900">Rp {{ number_format($jurusanStats['RPL'], 0, ',', '.') }}</span>
                    </div>
                </div>
                <!-- AK -->
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span class="flex items-center space-x-1.5 text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                            <span>AK (Rp 500.000 / bln)</span>
                        </span>
                        <span class="font-extrabold text-slate-900">Rp {{ number_format($jurusanStats['AK'], 0, ',', '.') }}</span>
                    </div>
                </div>
                <!-- MP -->
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span class="flex items-center space-x-1.5 text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                            <span>MP (Rp 450.000 / bln)</span>
                        </span>
                        <span class="font-extrabold text-slate-900">Rp {{ number_format($jurusanStats['MP'], 0, ',', '.') }}</span>
                    </div>
                </div>
                <!-- BR -->
                <div>
                    <div class="flex justify-between text-xs font-semibold mb-1">
                        <span class="flex items-center space-x-1.5 text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span>BR (Rp 420.000 / bln)</span>
                        </span>
                        <span class="font-extrabold text-slate-900">Rp {{ number_format($jurusanStats['BR'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Transaksi Kasir Terkini (Full Width Luas & Bersih) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-7">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Aktivitas Transaksi Kasir</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar pembayaran SPP yang baru saja diverifikasi dan masuk sistem</p>
                </div>
                <a href="{{ route('transaksi.history') }}" 
                   class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center space-x-1.5 bg-indigo-50 hover:bg-indigo-100 px-3.5 py-2 rounded-xl transition">
                    <span>Semua History</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-3 font-bold">Siswa & Kelas</th>
                            <th class="py-3 px-3 font-bold">Bulan SPP</th>
                            <th class="py-3 px-3 font-bold">Nominal</th>
                            <th class="py-3 px-3 font-bold">Petugas</th>
                            <th class="py-3 px-3 text-right font-bold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($transaksiTerbaru as $trx)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center font-extrabold text-xs shadow-sm">
                                            {{ strtoupper(substr($trx->siswa->nama ?? 'S', 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-xs sm:text-sm">{{ $trx->siswa->nama ?? 'Siswa Terhapus' }}</div>
                                            <div class="text-[11px] text-slate-400 flex items-center space-x-1.5 mt-0.5">
                                                <span>{{ $trx->siswa->kelas->nama_kelas ?? '-' }}</span>
                                                <span>•</span>
                                                <span>NISN: {{ $trx->nisn }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">
                                        {{ $trx->bulan_dibayar }} {{ $trx->tahun_dibayar }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 font-extrabold text-emerald-600 text-xs sm:text-sm">
                                    Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-3 text-xs text-slate-600">
                                    <span class="flex items-center space-x-1.5">
                                        <i class="fa-solid fa-user-check text-slate-400 text-[11px]"></i>
                                        <span>{{ $trx->petugas->nama_petugas ?? 'Petugas' }}</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 text-right">
                                    <a href="{{ route('transaksi.kuitansi', $trx->id_pembayaran) }}" target="_blank"
                                       class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 text-slate-700 hover:bg-indigo-600 hover:text-white transition shadow-sm">
                                        <i class="fa-solid fa-print mr-1 text-[11px]"></i>
                                        <span>Kuitansi</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">Belum ada transaksi pembayaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

<!-- Inisialisasi Chart.js Modern FinTech -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Dynamic Greeting
        const hour = new Date().getHours();
        let greeting = "Selamat Datang";
        if (hour >= 4 && hour < 11) greeting = "Selamat Pagi";
        else if (hour >= 11 && hour < 15) greeting = "Selamat Siang";
        else if (hour >= 15 && hour < 18) greeting = "Selamat Sore";
        else greeting = "Selamat Malam";
        const greetEl = document.getElementById('dynamicGreeting');
        if (greetEl) greetEl.innerText = greeting;

        // 1. Chart Tren Arus Kas Masuk 12 Bulan (Gradient Area Line Chart Dribbble Style)
        const ctxTren = document.getElementById('chartTrenBulanan').getContext('2d');
        
        // Gradient Fill
        const gradientFill = ctxTren.createLinearGradient(0, 0, 0, 300);
        gradientFill.addColorStop(0, 'rgba(79, 70, 229, 0.35)');
        gradientFill.addColorStop(1, 'rgba(79, 70, 229, 0.00)');

        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: {!! json_encode($namaBulan) !!},
                datasets: [{
                    label: 'Kas Diterima (Rp)',
                    data: {!! json_encode($trenBulananData) !!},
                    borderColor: '#4f46e5',
                    borderWidth: 3,
                    fill: true,
                    backgroundColor: gradientFill,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#94a3b8',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 12,
                        callbacks: {
                            label: function(context) {
                                return 'Kas Masuk: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) { 
                                if (value === 0) return 'Rp 0';
                                return 'Rp ' + (value/1000) + 'k'; 
                            },
                            font: { size: 11, family: 'Plus Jakarta Sans' }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, family: 'Plus Jakarta Sans' }
                        }
                    }
                }
            }
        });

        // 2. Donut Chart Kontribusi per Jurusan (FinTech Doughnut)
        const ctxDonut = document.getElementById('chartKontribusiJurusan').getContext('2d');
        const dataJurusan = [
            {{ $jurusanStats['RPL'] ?? 0 }},
            {{ $jurusanStats['AK'] ?? 0 }},
            {{ $jurusanStats['MP'] ?? 0 }},
            {{ $jurusanStats['BR'] ?? 0 }}
        ];

        // Jika semua data 0, tampilkan default seimbang untuk visualisasi
        const hasData = dataJurusan.some(val => val > 0);
        const finalData = hasData ? dataJurusan : [600000, 500000, 450000, 420000];

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['RPL', 'AK', 'MP', 'BR'],
                datasets: [{
                    data: finalData,
                    backgroundColor: ['#4f46e5', '#a855f7', '#3b82f6', '#f59e0b'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '74%',
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection