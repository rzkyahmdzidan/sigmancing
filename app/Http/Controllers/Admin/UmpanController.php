<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umpan;
use Illuminate\Http\Request;

class UmpanController extends Controller
{
    public function index()
    {
        $umpans = Umpan::latest()->paginate(12);
        return view('admin.umpan.index', compact('umpans'));
    }

    // Tambahkan method edit ini
    public function edit(Umpan $umpan)
    {
        return response()->json($umpan);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_ikan' => 'required|string',
            'jenis_air' => 'required|string',
            'waktu_terbaik' => 'required|string',
            'deskripsi' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'required|boolean'
        ]);

        Umpan::create($validated);

        return redirect()
            ->route('admin.umpan.index')
            ->with('success', 'Rekomendasi umpan berhasil ditambahkan');
    }

    public function update(Request $request, Umpan $umpan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jenis_ikan' => 'required|string',
            'jenis_air' => 'required|string',
            'waktu_terbaik' => 'required|string',
            'deskripsi' => 'nullable|string',
            'badge' => 'nullable|string',
            'status' => 'required|boolean'
        ]);

        $umpan->update($validated);

        return redirect()
            ->route('admin.umpan.index')
            ->with('success', 'Rekomendasi umpan berhasil diperbarui');
    }

    public function destroy(Umpan $umpan)
    {
        $umpan->delete();

        return redirect()
            ->route('admin.umpan.index')
            ->with('success', 'Rekomendasi umpan berhasil dihapus');
    }
}
