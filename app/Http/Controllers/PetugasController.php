<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::latest()->paginate(10);
        return view('admin.petugas.index', compact('petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:petugas,username|max:25',
            'password' => 'required|min:4',
            'nama_petugas' => 'required|max:35',
            'level' => 'required|in:admin,petugas',
        ]);

        Petugas::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama_petugas' => $request->nama_petugas,
            'level' => $request->level,
        ]);

        return back()->with('success', 'Data petugas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $request->validate([
            'username' => 'required|max:25|unique:petugas,username,' . $id . ',id_petugas',
            'nama_petugas' => 'required|max:35',
            'level' => 'required|in:admin,petugas',
        ]);

        $data = [
            'username' => $request->username,
            'nama_petugas' => $request->nama_petugas,
            'level' => $request->level,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);
        return back()->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        if ($petugas->id_petugas === auth('petugas')->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri!');
        }
        $petugas->delete();
        return back()->with('success', 'Data petugas berhasil dihapus!');
    }
}
