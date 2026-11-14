<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::latest()->paginate(10);
        return view('admin.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|max:10',
            'kompetensi_keahlian' => 'required|max:50',
        ]);

        Kelas::create($request->all());
        return back()->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|max:10',
            'kompetensi_keahlian' => 'required|max:50',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());
        return back()->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return back()->with('success', 'Data kelas berhasil dihapus!');
    }
}
