@extends('layouts.app')

@section('title', 'Data SPP')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data SPP</h1>
            <p class="text-xs text-slate-400">Atur nominal tarif SPP per tahun ajaran</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center space-x-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Tarif SPP</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">No</th>
                        <th class="py-3.5 px-4 font-semibold">Tahun</th>
                        <th class="py-3.5 px-4 font-semibold">Nominal Per Bulan</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($spp as $index => $item)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4 text-slate-500 text-xs">{{ $spp->firstItem() + $index }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-800">Tahun {{ $item->tahun }}</td>
                            <td class="py-3.5 px-4 font-semibold text-emerald-600">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <button onclick="editSpp({{ $item->id_spp }}, '{{ $item->tahun }}', '{{ $item->nominal }}')"
                                        class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition text-xs">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('spp.destroy', $item->id_spp) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data tarif SPP ini?')">
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
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada data tarif SPP</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $spp->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah SPP -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Tambah Tarif SPP</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('spp.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Tahun</label>
                <input type="number" name="tahun" required placeholder="Contoh: 2026" value="{{ date('Y') }}"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nominal Per Bulan (Rp)</label>
                <input type="number" name="nominal" required placeholder="Contoh: 400000"
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

<!-- Modal Edit SPP -->
<div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Edit Tarif SPP</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form id="formEditSpp" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Tahun</label>
                <input type="number" name="tahun" id="editTahun" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nominal Per Bulan (Rp)</label>
                <input type="number" name="nominal" id="editNominal" required
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
    function editSpp(id, tahun, nominal) {
        document.getElementById('formEditSpp').action = '/spp/' + id;
        document.getElementById('editTahun').value = tahun;
        document.getElementById('editNominal').value = nominal;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
@endsection
