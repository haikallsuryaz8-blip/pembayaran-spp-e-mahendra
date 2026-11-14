<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
        $spp = Spp::orderBy('tahun', 'desc')->paginate(10);
        return view('admin.spp.index', compact('spp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|numeric|digits:4',
            'nominal' => 'required|numeric',
        ]);

        Spp::create($request->all());
        return back()->with('success', 'Data SPP berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required|numeric|digits:4',
            'nominal' => 'required|numeric',
        ]);

        $spp = Spp::findOrFail($id);
        $spp->update($request->all());
        return back()->with('success', 'Data SPP berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $spp = Spp::findOrFail($id);
        $spp->delete();
        return back()->with('success', 'Data SPP berhasil dihapus!');
    }
}
