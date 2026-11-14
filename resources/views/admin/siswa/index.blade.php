@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Siswa</h1>
            <p class="text-xs text-slate-400">Manajemen data siswa, NISN, kelas, dan tarif SPP yang berlaku</p>
        </div>
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-md transition flex items-center space-x-2">
            <i class="fa-solid fa-user-plus"></i>
            <span>Tambah Siswa</span>
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/80 text-xs text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 font-semibold">NISN & NIS</th>
                        <th class="py-3.5 px-4 font-semibold">Nama Siswa</th>
                        <th class="py-3.5 px-4 font-semibold">Kelas</th>
                        <th class="py-3.5 px-4 font-semibold">Tarif SPP</th>
                        <th class="py-3.5 px-4 font-semibold">No Telp</th>
                        <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswa as $s)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-800">{{ $s->nisn }}</div>
                                <div class="text-xs text-slate-400">NIS: {{ $s->nis }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $s->nama }}</td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700">
                                    {{ $s->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="text-xs font-semibold text-slate-700">Thn {{ $s->spp->tahun ?? '-' }}</div>
                                <div class="text-xs text-emerald-600 font-bold">Rp {{ number_format($s->spp->nominal ?? 0, 0, ',', '.') }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-500">{{ $s->no_telp ?? '-' }}</td>
                            <td class="py-3.5 px-4 text-right space-x-1.5 whitespace-nowrap">
                                <a href="{{ route('transaksi.index', ['nisn' => $s->nisn]) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition text-xs font-semibold">
                                    <i class="fa-solid fa-money-bill-wave mr-1"></i> Bayar
                                </a>
                                <button onclick="editSiswa('{{ $s->nisn }}', '{{ $s->nis }}', '{{ $s->nama }}', {{ $s->id_kelas }}, {{ $s->id_spp }}, '{{ $s->no_telp }}', '{{ addslashes($s->alamat) }}')"
                                        class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition text-xs">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('siswa.destroy', $s->nisn) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
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
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data siswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100">
            {{ $siswa->links() }}
        </div>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div id="modalTambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Tambah Siswa Baru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form action="{{ route('siswa.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">NISN (10 Digit)</label>
                    <input type="text" name="nisn" required maxlength="10" placeholder="0012345678"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">NIS (8 Digit)</label>
                    <input type="text" name="nis" required maxlength="8" placeholder="12345678"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nama Lengkap Siswa</label>
                <input type="text" name="nama" required placeholder="Nama Siswa"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Kelas</label>
                    <select name="id_kelas" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->kompetensi_keahlian }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Tarif SPP</label>
                    <select name="id_spp" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="">Pilih SPP</option>
                        @foreach($spp as $sp)
                            <option value="{{ $sp->id_spp }}">Tahun {{ $sp->tahun }} - Rp {{ number_format($sp->nominal, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">No Telepon / WA</label>
                <input type="text" name="no_telp" placeholder="08xxxxxxxxxx"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Alamat Siswa</label>
                <textarea name="alamat" rows="2" placeholder="Alamat tempat tinggal siswa"
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 font-medium hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow">Simpan Data Siswa</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Siswa -->
<div id="modalEdit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg text-slate-800">Edit Data Siswa</h3>
            <button onclick="document.getElementById('modalEdit').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>
        <form id="formEditSiswa" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">NISN (Permanen)</label>
                    <input type="text" id="editNisn" disabled
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">NIS</label>
                    <input type="text" name="nis" id="editNis" required maxlength="8"
                           class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Nama Lengkap Siswa</label>
                <input type="text" name="nama" id="editNama" required
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Kelas</label>
                    <select name="id_kelas" id="editIdKelas" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->kompetensi_keahlian }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Tarif SPP</label>
                    <select name="id_spp" id="editIdSpp" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        @foreach($spp as $sp)
                            <option value="{{ $sp->id_spp }}">Tahun {{ $sp->tahun }} - Rp {{ number_format($sp->nominal, 0, ',', '.') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">No Telepon / WA</label>
                <input type="text" name="no_telp" id="editNoTelp"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Alamat Siswa</label>
                <textarea name="alamat" id="editAlamat" rows="2"
                          class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1 uppercase">Password Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password"
                       class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" onclick="document.getElementById('modalEdit').classList.add('hidden')"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-sm text-slate-600 font-medium hover:bg-slate-50">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold shadow">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editSiswa(nisn, nis, nama, idKelas, idSpp, noTelp, alamat) {
        document.getElementById('formEditSiswa').action = '/siswa/' + nisn;
        document.getElementById('editNisn').value = nisn;
        document.getElementById('editNis').value = nis;
        document.getElementById('editNama').value = nama;
        document.getElementById('editIdKelas').value = idKelas;
        document.getElementById('editIdSpp').value = idSpp;
        document.getElementById('editNoTelp').value = noTelp;
        document.getElementById('editAlamat').value = alamat;
        document.getElementById('modalEdit').classList.remove('hidden');
    }
</script>
@endsection
