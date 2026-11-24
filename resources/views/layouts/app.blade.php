<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pembayaran SPP Infinity') - SMK JAKARTA PUSAT 1</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js for Beautiful Dashboards -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="theme-color" content="#0f172a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-tap-highlight-color: transparent; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col text-slate-800 antialiased">

    <!-- Top Academic Navbar -->
    <header class="bg-slate-900 text-white shadow-sm sticky top-0 z-50 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- School Brand & Identity -->
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white text-base font-bold shadow-sm">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-base sm:text-lg font-bold tracking-tight text-white">Pembayaran SPP Infinity</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md border {{ auth('petugas')->check() ? (auth('petugas')->user()->level === 'admin' ? 'bg-amber-500/20 text-amber-300 border-amber-500/30' : 'bg-blue-500/20 text-blue-300 border-blue-500/30') : 'bg-emerald-500/20 text-emerald-300 border-emerald-500/30' }}">
                                {{ auth('petugas')->check() ? strtoupper(auth('petugas')->user()->level) : 'PORTAL SISWA' }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 hidden sm:block font-medium">SMK JAKARTA PUSAT 1 • T.A. 2026</p>
                    </div>
                </div>

                <!-- User Profile & Action -->
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs sm:text-sm font-semibold text-white flex items-center justify-end space-x-1.5">
                            <span>{{ auth('petugas')->check() ? auth('petugas')->user()->nama_petugas : auth('siswa')->user()->nama }}</span>
                            <i class="fa-solid fa-circle-check text-emerald-400 text-xs"></i>
                        </div>
                        <div class="text-[11px] text-slate-400 font-mono">
                            {{ auth('petugas')->check() ? '@' . auth('petugas')->user()->username : 'NISN: ' . auth('siswa')->user()->nisn }}
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Keluar dari akun"
                                class="bg-rose-500/10 hover:bg-rose-600 text-rose-300 hover:text-white border border-rose-500/30 hover:border-transparent px-3 py-1.5 sm:px-3 sm:py-2 rounded-xl text-xs font-semibold transition-all duration-150 flex items-center space-x-1.5 shadow-sm">
                            <i class="fa-solid fa-power-off text-xs"></i>
                            <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex-1 flex max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 gap-6">
        <!-- Sidebar Desktop Navigation -->
        <aside class="w-64 flex-shrink-0 hidden md:block">
            <nav class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-3 space-y-1 sticky top-24">
                @if(auth('petugas')->check())
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-chart-pie w-5 text-center {{ request()->routeIs('dashboard') ? 'text-white' : 'text-blue-600' }}"></i>
                        <span>Dashboard Utama</span>
                    </a>

                    <div class="pt-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3">
                        Transaksi Kasir
                    </div>
                    <a href="{{ route('transaksi.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('transaksi.index') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-cash-register w-5 text-center {{ request()->routeIs('transaksi.index') ? 'text-white' : 'text-blue-600' }}"></i>
                        <span>Entri Pembayaran</span>
                    </a>
                    <a href="{{ route('transaksi.history') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('transaksi.history') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 text-center {{ request()->routeIs('transaksi.history') ? 'text-white' : 'text-blue-600' }}"></i>
                        <span>History Transaksi</span>
                    </a>

                    @if(auth('petugas')->user()->level === 'admin')
                        <div class="pt-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3">
                            Master Data (Admin)
                        </div>
                        <a href="{{ route('siswa.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('siswa.*') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid fa-user-graduate w-5 text-center {{ request()->routeIs('siswa.*') ? 'text-white' : 'text-blue-600' }}"></i>
                            <span>Data Siswa</span>
                        </a>
                        <a href="{{ route('kelas.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('kelas.*') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid fa-school w-5 text-center {{ request()->routeIs('kelas.*') ? 'text-white' : 'text-blue-600' }}"></i>
                            <span>Data Kelas</span>
                        </a>
                        <a href="{{ route('spp.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('spp.*') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid fa-receipt w-5 text-center {{ request()->routeIs('spp.*') ? 'text-white' : 'text-blue-600' }}"></i>
                            <span>Tarif SPP</span>
                        </a>
                        <a href="{{ route('petugas.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('petugas.*') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid fa-user-tie w-5 text-center {{ request()->routeIs('petugas.*') ? 'text-white' : 'text-blue-600' }}"></i>
                            <span>Manajemen Petugas</span>
                        </a>

                        <div class="pt-3 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3">
                            Laporan Keuangan
                        </div>
                        <a href="{{ route('laporan.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-medium text-xs sm:text-sm transition-all {{ request()->routeIs('laporan.*') ? 'bg-blue-600 text-white font-semibold shadow-sm' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fa-solid fa-file-invoice-dollar w-5 text-center {{ request()->routeIs('laporan.*') ? 'text-white' : 'text-blue-600' }}"></i>
                            <span>Rekapitulasi Laporan</span>
                        </a>
                    @endif
                @else
                    <!-- Menu Khusus Siswa -->
                    <div class="pt-1 pb-1 text-[10px] font-bold text-slate-400 uppercase tracking-wider px-3">
                        Portal Mandiri Siswa
                    </div>
                    <a href="{{ route('siswa.history') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl font-semibold text-xs sm:text-sm transition-all bg-blue-600 text-white shadow-sm">
                        <i class="fa-solid fa-wallet w-5 text-center text-white"></i>
                        <span>Tagihan & Riwayat SPP</span>
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden pb-20 md:pb-6">
            <!-- Alert Notifications Flash Messages -->
            @if(session('success'))
                <div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl shadow-sm">
                    <div class="flex items-center space-x-2 font-bold text-xs sm:text-sm mb-1.5">
                        <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                        <span>Terdapat kesalahan input formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 pl-4 font-medium">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bottom Navigation Bar Khusus Tampilan Mobile (Smartphones) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 px-2 py-1.5 shadow-lg">
        <div class="flex items-center justify-around">
            @if(auth('petugas')->check())
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center py-1 px-2 {{ request()->routeIs('dashboard') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                    <i class="fa-solid fa-chart-pie text-base mb-0.5"></i>
                    <span class="text-[10px]">Dashboard</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="flex flex-col items-center py-1 px-2 {{ request()->routeIs('transaksi.index') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                    <i class="fa-solid fa-cash-register text-base mb-0.5"></i>
                    <span class="text-[10px]">Bayar SPP</span>
                </a>
                <a href="{{ route('transaksi.history') }}" class="flex flex-col items-center py-1 px-2 {{ request()->routeIs('transaksi.history') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                    <i class="fa-solid fa-clock-rotate-left text-base mb-0.5"></i>
                    <span class="text-[10px]">History</span>
                </a>
                @if(auth('petugas')->user()->level === 'admin')
                    <a href="{{ route('siswa.index') }}" class="flex flex-col items-center py-1 px-2 {{ request()->routeIs('siswa.*') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                        <i class="fa-solid fa-user-graduate text-base mb-0.5"></i>
                        <span class="text-[10px]">Siswa</span>
                    </a>
                    <a href="{{ route('laporan.index') }}" class="flex flex-col items-center py-1 px-2 {{ request()->routeIs('laporan.*') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }}">
                        <i class="fa-solid fa-file-invoice-dollar text-base mb-0.5"></i>
                        <span class="text-[10px]">Laporan</span>
                    </a>
                @endif
            @else
                <!-- Menu Mobile Siswa -->
                <a href="{{ route('siswa.history') }}" class="flex flex-col items-center py-1 px-4 text-blue-600 font-bold">
                    <i class="fa-solid fa-wallet text-lg mb-0.5"></i>
                    <span class="text-[10px]">Tagihan SPP</span>
                </a>
                <div class="flex flex-col items-center py-1 px-4 text-slate-500">
                    <i class="fa-solid fa-circle-check text-lg mb-0.5 text-emerald-500"></i>
                    <span class="text-[10px] text-emerald-600 font-bold">Status Siswa</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex flex-col items-center py-1 px-4 text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-power-off text-lg mb-0.5"></i>
                        <span class="text-[10px] font-bold">Keluar</span>
                    </button>
                </form>
            @endif
        </div>
    </nav>

</body>
</html>