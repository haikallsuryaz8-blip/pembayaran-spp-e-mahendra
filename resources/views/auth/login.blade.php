<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pembayaran SPP - E.Mahendra</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 relative overflow-hidden select-none">

    <!-- Ambient Glow Background Effects -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/30 rounded-full blur-[128px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-violet-600/30 rounded-full blur-[128px] pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[160px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10">
        <!-- Main Card with Glassmorphism -->
        <div class="bg-white/[0.08] backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/10 p-7 sm:p-9 text-white">
            
            <!-- School Header & Badge -->
            <div class="text-center mb-7">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-lg shadow-indigo-500/40 mb-4 border border-white/20">
                    <i class="fa-solid fa-graduation-cap text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-extrabold tracking-tight text-white">Pembayaran SPP - E.Mahendra</h1>
                <p class="text-xs text-indigo-200/80 mt-1 font-medium tracking-wide">
                    SMK JAKARTA PUSAT 1 • Portal Resmi
                </p>
                <div class="inline-flex items-center space-x-1.5 mt-2.5 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[11px] text-indigo-300">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Tahun Ajaran Aktif 2026</span>
                </div>
            </div>

            <!-- Flash Notifications -->
            @if(session('error'))
                <div class="mb-5 bg-rose-500/15 border border-rose-500/30 text-rose-200 px-4 py-3 rounded-2xl text-xs flex items-center space-x-2.5 backdrop-blur-md">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-sm flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 bg-emerald-500/15 border border-emerald-500/30 text-emerald-200 px-4 py-3 rounded-2xl text-xs flex items-center space-x-2.5 backdrop-blur-md">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-sm flex-shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Toggle Role Switcher -->
                <div>
                    <label class="block text-[11px] font-bold text-indigo-200/70 uppercase tracking-wider mb-2">Pilih Role Akses</label>
                    <div class="grid grid-cols-2 gap-1.5 bg-black/20 p-1.5 rounded-2xl border border-white/10">
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="login_type" value="petugas" class="sr-only peer" checked onchange="toggleLoginType('petugas')">
                            <div class="py-2.5 px-2 rounded-xl text-xs font-semibold text-slate-400 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:shadow-md peer-checked:shadow-indigo-600/30 transition-all flex items-center justify-center space-x-1.5">
                                <i class="fa-solid fa-user-tie"></i>
                                <span>Petugas / Admin</span>
                            </div>
                        </label>
                        <label class="cursor-pointer text-center">
                            <input type="radio" name="login_type" value="siswa" class="sr-only peer" onchange="toggleLoginType('siswa')">
                            <div class="py-2.5 px-2 rounded-xl text-xs font-semibold text-slate-400 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:shadow-md peer-checked:shadow-indigo-600/30 transition-all flex items-center justify-center space-x-1.5">
                                <i class="fa-solid fa-user-graduate"></i>
                                <span>Siswa</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Input Username / NISN -->
                <div>
                    <label id="usernameLabel" class="block text-xs font-semibold text-indigo-100 mb-1.5">
                        Username Petugas
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-indigo-300/60">
                            <i id="userIcon" class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="username" id="usernameInput" value="{{ old('username') }}" required autofocus
                               class="w-full pl-10 pr-4 py-3 rounded-2xl bg-white/5 border border-white/15 text-white placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition"
                               placeholder="Masukkan username petugas">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-indigo-100">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-indigo-300/60">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="passwordInput" required
                               class="w-full pl-10 pr-11 py-3 rounded-2xl bg-white/5 border border-white/15 text-white placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-400 transition"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility()" aria-label="Toggle password"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-indigo-300/60 hover:text-white transition focus:outline-none">
                            <i id="eyeIcon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                    <p id="passwordHint" class="text-[11px] text-indigo-300/70 mt-1.5 hidden flex items-center space-x-1">
                        <i class="fa-solid fa-circle-info text-[10px]"></i>
                        <span>Untuk akun Siswa, gunakan <strong>NIS</strong> Anda sebagai kata sandi.</span>
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold py-3.5 px-4 rounded-2xl shadow-xl shadow-indigo-600/30 transition-all duration-200 active:scale-[0.99] text-sm flex items-center justify-center space-x-2">
                    <span>Masuk ke Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-white/10 text-center text-[11px] text-slate-400">
                <span>Rekayasa Perangkat Lunak &copy; 2026 • Haikal Suryadarmansyah</span>
            </div>
        </div>
    </div>

    <!-- Script Interaktif -->
    <script>
        function toggleLoginType(type) {
            const label = document.getElementById('usernameLabel');
            const input = document.getElementById('usernameInput');
            const hint = document.getElementById('passwordHint');
            const userIcon = document.getElementById('userIcon');

            if (type === 'siswa') {
                label.innerText = 'NISN / NIS Siswa';
                input.placeholder = 'Ketik NISN atau NIS Anda';
                hint.classList.remove('hidden');
                userIcon.className = 'fa-solid fa-id-card';
            } else {
                label.innerText = 'Username Petugas';
                input.placeholder = 'Masukkan username petugas';
                hint.classList.add('hidden');
                userIcon.className = 'fa-solid fa-user';
            }
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>