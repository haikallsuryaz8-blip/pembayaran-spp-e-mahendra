@extends('layouts.app')

@section('title', 'Dashboard Admin & Petugas')

@section('content')
<div class="space-y-6">

    <!-- Top Action Bar & Greeting (Clean Academic Executive Header) -->
    <div class="bg-white rounded-2xl p-6 sm:p-7 border border-slate-200/80 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
            <div class="space-y-1.5 max-w-2xl">
                <div class="inline-flex items-center space-x-2 bg-slate-100 px-3 py-1 rounded-md text-xs font-semibold text-slate-700 border border-slate-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Panel Kendali {{ strtoupper(auth('petugas')->user()->level) }}</span>
                    <span class="text-slate-300">•</span>
                    <span class="text-blue-700">Tahun Ajaran 2026</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                    <span id="dynamicGreeting">Selamat Datang</span>, {{ auth('petugas')->user()->nama_petugas }}! 👋
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed font-normal">
                    Pusat monitoring keuangan Pembayaran SPP Infinity SMK Jakarta Pusat 1. Pantau arus kas masuk, status pelunasan siswa, dan rekapitulasi 4 jurusan.
                </p>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('transaksi.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm shadow-sm transition-all duration-150 flex items-center space-x-2 active:scale-95">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    <span>Entri Pembayaran</span>
                </a>
                @if(auth('petugas')->user()->level === 'admin')
                    <a href="{{ route('laporan.index') }}" 
                       class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-xs sm:text-sm transition-all duration-150 flex items-center space-x-2 border border-slate-200">
                        <i class="fa-solid fa-file-invoice-dollar text-slate-600"></i>
                        <span>Cetak Laporan</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- 4 Metric Cards (Clean Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Total Kas Terkumpul (All-Time) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Kas Masuk</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-vault"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mt-2.5">
                Rp {{ number_format($totalKasAllTime, 0, ',', '.') }}
            </h3>
            <div class="mt-3 flex items-center justify-between text-xs pt-3 border-t border-slate-100">
                <span class="text-slate-500">Bulan Berjalan:</span>
                <span class="font-bold text-blue-600">Rp {{ number_format($totalTransaksiBulanIni, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Partisipasi Pembayaran Siswa -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Siswa Sudah Bayar</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <div class="flex items-baseline space-x-1.5 mt-2.5">
                <h3 class="text-2xl font-bold text-slate-900">{{ $siswaSudahBayarCount }}</h3>
                <span class="text-xs text-slate-400 font-medium">/ {{ $totalSiswa }} Siswa</span>
            </div>
            <!-- Progress Bar -->
            <div class="mt-3 pt-3 border-t border-slate-100">
                <div class="flex justify-between text-xs mb-1 font-medium">
                    <span class="text-slate-500">Partisipasi</span>
                    <span class="text-emerald-700 font-semibold">{{ $persentasePartisipasi }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ max($persentasePartisipasi, 5) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Rombel & Kelas -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rombel Kelas</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-base">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mt-2.5">{{ $totalKelas }} Kelas</h3>
            <div class="mt-3 flex items-center space-x-2 text-xs pt-3 border-t border-slate-100 text-slate-500">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                <span>Tingkat X, XI, XII (4 Jurusan)</span>
            </div>
        </div>

        <!-- Operator Kasir / TU -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Petugas & Admin</span>
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center text-base">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mt-2.5">{{ $totalPetugas }} Akun</h3>
            <div class="mt-3 flex items-center justify-between text-xs pt-3 border-t border-slate-100 text-slate-500">
                <span class="flex items-center space-x-1 text-emerald-700 font-semibold">
                    <i class="fa-solid fa-circle-check text-[10px]"></i>
                    <span>Multi-Guard Aktif</span>
                </span>
                <span class="text-slate-400">Petugas / Siswa</span>
            </div>
        </div>

    </div>

    <!-- Charts & Analytics Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Wide Chart: Tren Arus Kas Masuk 12 Bulan -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                <div>
                    <div class="flex items-center space-x-2">
                        <h3 class="font-bold text-slate-900 text-base">Arus Kas Masuk Bulanan</h3>
                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                            Tahun 2026
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Grafik akumulasi pembayaran SPP siswa per bulan kalender</p>
                </div>
            </div>
            <div class="h-64 sm:h-72">
                <canvas id="chartTrenBulanan"></canvas>
            </div>
        </div>

        <!-- Right Chart: Perbandingan Kas Masuk 4 Jurusan -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="mb-4">
                    <h3 class="font-bold text-slate-900 text-base">Kontribusi Kas per Jurusan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Akumulasi penerimaan SPP 4 kejuruan</p>
                </div>

                <div class="h-44 flex items-center justify-center my-2">
                    <canvas id="chartKontribusiJurusan"></canvas>
                </div>
            </div>

            <!-- List Breakdown Jurusan -->
            <div class="space-y-2.5 pt-4 border-t border-slate-100">
                <!-- RPL -->
                <div class="flex justify-between text-xs font-medium">
                    <span class="flex items-center space-x-2 text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span>RPL (Rp 600.000 / bln)</span>
                    </span>
                    <span class="font-bold text-slate-900">Rp {{ number_format($jurusanStats['RPL'], 0, ',', '.') }}</span>
                </div>
                <!-- AK -->
                <div class="flex justify-between text-xs font-medium">
                    <span class="flex items-center space-x-2 text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                        <span>AK (Rp 500.000 / bln)</span>
                    </span>
                    <span class="font-bold text-slate-900">Rp {{ number_format($jurusanStats['AK'], 0, ',', '.') }}</span>
                </div>
                <!-- MP -->
                <div class="flex justify-between text-xs font-medium">
                    <span class="flex items-center space-x-2 text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        <span>MP (Rp 450.000 / bln)</span>
                    </span>
                    <span class="font-bold text-slate-900">Rp {{ number_format($jurusanStats['MP'], 0, ',', '.') }}</span>
                </div>
                <!-- BR -->
                <div class="flex justify-between text-xs font-medium">
                    <span class="flex items-center space-x-2 text-slate-700">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <span>BR (Rp 420.000 / bln)</span>
                    </span>
                    <span class="font-bold text-slate-900">Rp {{ number_format($jurusanStats['BR'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Bottom Section: Transaksi Kasir Terkini -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="font-bold text-slate-900 text-base">Aktivitas Transaksi Kasir</h3>
                <p class="text-xs text-slate-400 mt-0.5">Daftar pembayaran SPP yang baru saja diverifikasi dan masuk sistem</p>
            </div>
            <a href="{{ route('transaksi.history') }}" 
               class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center space-x-1.5 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                <span>Semua History</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase tracking-wider bg-slate-50/50">
                        <th class="py-3 px-3.5 font-semibold">Siswa & Kelas</th>
                        <th class="py-3 px-3.5 font-semibold">Bulan SPP</th>
                        <th class="py-3 px-3.5 font-semibold">Nominal</th>
                        <th class="py-3 px-3.5 font-semibold">Petugas</th>
                        <th class="py-3 px-3.5 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transaksiTerbaru as $trx)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-3.5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($trx->siswa->nama ?? 'S', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-900 text-xs sm:text-sm">{{ $trx->siswa->nama ?? 'Siswa Terhapus' }}</div>
                                        <div class="text-[11px] text-slate-400 flex items-center space-x-1.5 mt-0.5">
                                            <span>{{ $trx->siswa->kelas->nama_kelas ?? '-' }}</span>
                                            <span>•</span>
                                            <span>NISN: {{ $trx->nisn }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-3.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $trx->bulan_dibayar }} {{ $trx->tahun_dibayar }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3.5 font-bold text-emerald-700 text-xs sm:text-sm">
                                Rp {{ number_format($trx->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-3.5 text-xs text-slate-600">
                                <span class="flex items-center space-x-1.5">
                                    <i class="fa-solid fa-user-check text-slate-400 text-[11px]"></i>
                                    <span>{{ $trx->petugas->nama_petugas ?? 'Petugas' }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-3.5 text-right">
                                <a href="{{ route('transaksi.kuitansi', $trx->id_pembayaran) }}" target="_blank"
                                   class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-medium bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:text-blue-600 transition shadow-sm">
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

<!-- Inisialisasi Chart.js Clean Academic -->
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

        // 1. Chart Tren Arus Kas Masuk 12 Bulan (Clean Academic Line Chart)
        const ctxTren = document.getElementById('chartTrenBulanan').getContext('2d');
        
        const gradientFill = ctxTren.createLinearGradient(0, 0, 0, 300);
        gradientFill.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
        gradientFill.addColorStop(1, 'rgba(37, 99, 235, 0.00)');

        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: {!! json_encode($namaBulan) !!},
                datasets: [{
                    label: 'Kas Diterima (Rp)',
                    data: {!! json_encode($trenBulananData) !!},
                    borderColor: '#2563eb',
                    borderWidth: 2.5,
                    fill: true,
                    backgroundColor: gradientFill,
                    tension: 0.3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#2563eb',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#94a3b8',
                        bodyColor: '#ffffff',
                        padding: 10,
                        cornerRadius: 8,
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

        // 2. Donut Chart Kontribusi per Jurusan
        const ctxDonut = document.getElementById('chartKontribusiJurusan').getContext('2d');
        const dataJurusan = [
            {{ $jurusanStats['RPL'] ?? 0 }},
            {{ $jurusanStats['AK'] ?? 0 }},
            {{ $jurusanStats['MP'] ?? 0 }},
            {{ $jurusanStats['BR'] ?? 0 }}
        ];

        const hasData = dataJurusan.some(val => val > 0);
        const finalData = hasData ? dataJurusan : [600000, 500000, 450000, 420000];

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['RPL', 'AK', 'MP', 'BR'],
                datasets: [{
                    data: finalData,
                    backgroundColor: ['#2563eb', '#7c3aed', '#0284c7', '#d97706'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 8,
                        cornerRadius: 8,
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
