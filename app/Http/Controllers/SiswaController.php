<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas', 'spp'])->latest()->paginate(10);
        $kelas = Kelas::all();
        $spp = Spp::orderBy('tahun', 'desc')->get();

        return view('admin.siswa.index', compact('siswa', 'kelas', 'spp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|digits:10|unique:siswa,nisn',
            'nis' => 'required|digits:8|unique:siswa,nis',
            'nama' => 'required|max:35',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_spp' => 'required|exists:spp,id_spp',
            'alamat' => 'nullable',
            'no_telp' => 'nullable|max:13',
        ]);

        Siswa::create([
            'nisn' => $request->nisn,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->id_kelas,
            'id_spp' => $request->id_spp,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->nis), // default password NIS
        ]);

        return back()->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function update(Request $request, $nisn)
    {
        $siswa = Siswa::findOrFail($nisn);

        $request->validate([
            'nis' => 'required|digits:8|unique:siswa,nis,' . $nisn . ',nisn',
            'nama' => 'required|max:35',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_spp' => 'required|exists:spp,id_spp',
            'alamat' => 'nullable',
            'no_telp' => 'nullable|max:13',
        ]);

        $data = [
            'nis' => $request->nis,
            'nama' => $request->nama,
            'id_kelas' => $request->id_kelas,
            'id_spp' => $request->id_spp,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $siswa->update($data);
        return back()->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($nisn)
    {
        $siswa = Siswa::findOrFail($nisn);
        $siswa->delete();
        return back()->with('success', 'Data siswa berhasil dihapus!');
    }
}
