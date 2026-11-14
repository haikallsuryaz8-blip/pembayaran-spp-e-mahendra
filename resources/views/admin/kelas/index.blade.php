@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Kelas</h1>
            <p class="text-xs text-slate-400">Manajemen tingkatan kelas dan kompetensi keahlian</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Kelas</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">No</th>
                        <th class="py-3.5 px-4 font-semibold">Nama Kelas</th>
                        <th class="py-3.5 px-4 font-semibold">Kompetensi Keahlian (Jurusan)</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($kelas as $index => $k)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $kelas->firstItem() + $index }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">{{ $k->nama_kelas }}</td>
                            <td class="py-3.5 px-4 text-slate-600">{{ $k->kompetensi_keahlian }}</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button onclick="editKelas({{ $k->id_kelas }}, '{{ $k->nama_kelas }}', '{{ $k->kompetensi_keahlian }}')"
                                        class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition text-xs">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('kelas.destroy', $k->id_kelas) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition text-xs">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada data kelas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $kelas->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Tambah Kelas Baru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('kelas.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nama Kelas</label>
                <input type="text" name="nama_kelas" required placeholder="Contoh: XII RPL 1"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Kompetensi Keahlian</label>
                <input type="text" name="kompetensi_keahlian" required placeholder="Contoh: Rekayasa Perangkat Lunak"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 font-medium hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Edit Data Kelas</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form id="formEditKelas" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="editNamaKelas" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Kompetensi Keahlian</label>
                <input type="text" name="kompetensi_keahlian" id="editKompetensi" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
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
    function editKelas(id, nama, kompetensi) {
        document.getElementById('formEditKelas').action = '/kelas/' + id;
        document.getElementById('editNamaKelas').value = nama;
        document.getElementById('editKompetensi').value = kompetensi;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
@endsection
