@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Petugas & Admin</h1>
            <p class="text-xs text-slate-400">Manajemen akun pengguna sistem untuk Administrator dan Petugas</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Petugas</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">No</th>
                        <th class="py-3.5 px-4 font-semibold">Nama Petugas</th>
                        <th class="py-3.5 px-4 font-semibold">Username</th>
                        <th class="py-3.5 px-4 font-semibold">Level Hak Akses</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($petugas as $index => $p)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $petugas->firstItem() + $index }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ $p->nama_petugas }}</td>
                            <td class="py-3.5 px-4 text-slate-600 font-mono text-xs">@ {{ $p->username }}</td>
                            <td class="py-3.5 px-4">
                                @if($p->level === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i> Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-user-check mr-1 text-[10px]"></i> Petugas
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button onclick="editPetugas({{ $p->id_petugas }}, '{{ $p->nama_petugas }}', '{{ $p->username }}', '{{ $p->level }}')"
                                        class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition text-xs">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                @if($p->id_petugas !== auth('petugas')->id())
                                    <form action="{{ route('petugas.destroy', $p->id_petugas) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus akun petugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition text-xs">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data petugas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $petugas->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Petugas -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Tambah Petugas Baru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('petugas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nama Lengkap</label>
                <input type="text" name="nama_petugas" required placeholder="Nama Lengkap Petugas"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Username</label>
                <input type="text" name="username" required placeholder="username_petugas"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Level Hak Akses</label>
                <select name="level" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                    <option value="petugas">Petugas (Hanya Entri & History Transaksi)</option>
                    <option value="admin">Administrator (Akses Penuh Semua Menu)</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 font-medium hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Petugas -->
<div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Edit Data Petugas</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form id="formEditPetugas" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nama Lengkap</label>
                <input type="text" name="nama_petugas" id="editNamaPetugas" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Username</label>
                <input type="text" name="username" id="editUsername" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Level Hak Akses</label>
                <select name="level" id="editLevel" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                    <option value="petugas">Petugas (Hanya Entri & History Transaksi)</option>
                    <option value="admin">Administrator (Akses Penuh Semua Menu)</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 font-medium hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold shadow">Perbarui</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editPetugas(id, nama, username, level) {
        document.getElementById('formEditPetugas').action = '/petugas/' + id;
        document.getElementById('editNamaPetugas').value = nama;
        document.getElementById('editUsername').value = username;
        document.getElementById('editLevel').value = level;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
@endsection
