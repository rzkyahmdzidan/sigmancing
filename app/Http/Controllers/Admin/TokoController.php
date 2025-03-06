<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TokoController extends Controller
{
    public function index(Request $request)
    {
        $query = Toko::latest();

        // Filter pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'buka') {
                $now = Carbon::now('Asia/Jakarta')->format('H:i:s');
                $query->where('status', true)
                    ->where(function($q) use ($now) {
                        $q->whereRaw("? between jam_buka and jam_tutup", [$now])
                          ->orWhereRaw("(jam_tutup < jam_buka and (? >= jam_buka or ? <= jam_tutup))", [$now, $now]);
                    });
            } elseif ($request->status === 'tutup') {
                $now = Carbon::now('Asia/Jakarta')->format('H:i:s');
                $query->where('status', true)
                    ->where(function($q) use ($now) {
                        $q->whereRaw("? not between jam_buka and jam_tutup", [$now])
                          ->whereRaw("not (jam_tutup < jam_buka and (? >= jam_buka or ? <= jam_tutup))", [$now, $now]);
                    });
            } else {
                $query->where('status', $request->status === 'aktif');
            }
        }

        $toko = $query->paginate(10);
        return view('admin.toko.index', compact('toko'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|max:255',
                'alamat' => 'required',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'deskripsi' => 'required',
                'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'no_telp' => 'required',
                'jam_buka' => 'required',
                'jam_tutup' => 'required',
                'status' => 'required|boolean'
            ]);

            // Handle multiple image upload
            $gambarNames = [];
            if ($request->hasFile('gambar')) {
                foreach($request->file('gambar') as $image) {
                    $nama_gambar = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images/toko'), $nama_gambar);
                    $gambarNames[] = $nama_gambar;
                }
            }

            // Add gambar to validated data
            $validated['gambar'] = !empty($gambarNames) ? json_encode($gambarNames) : null;

            // Format jam menggunakan Carbon dengan timezone Asia/Jakarta
            $validated['jam_buka'] = Carbon::createFromTimeString($validated['jam_buka'], 'Asia/Jakarta')->format('H:i:s');
            $validated['jam_tutup'] = Carbon::createFromTimeString($validated['jam_tutup'], 'Asia/Jakarta')->format('H:i:s');

            // Create toko
            Toko::create($validated);

            return redirect()
                ->route('admin.toko.index')
                ->with('success', 'Toko berhasil ditambahkan');

        } catch (\Exception $e) {
            // Delete uploaded images if any error occurs
            if (!empty($gambarNames)) {
                foreach($gambarNames as $gambar) {
                    if(file_exists(public_path('images/toko/' . $gambar))) {
                        unlink(public_path('images/toko/' . $gambar));
                    }
                }
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan toko: ' . $e->getMessage());
        }
    }

    public function edit(Toko $toko)
    {
        return response()->json($toko);
    }

    public function update(Request $request, Toko $toko)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|max:255',
                'alamat' => 'required',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'deskripsi' => 'required',
                'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'no_telp' => 'required',
                'jam_buka' => 'required',
                'jam_tutup' => 'required',
                'status' => 'required|boolean'
            ]);

            // Format jam menggunakan Carbon dengan timezone Asia/Jakarta
            $validated['jam_buka'] = Carbon::createFromTimeString($validated['jam_buka'], 'Asia/Jakarta')->format('H:i:s');
            $validated['jam_tutup'] = Carbon::createFromTimeString($validated['jam_tutup'], 'Asia/Jakarta')->format('H:i:s');

            // Handle multiple image upload
            if ($request->hasFile('gambar')) {
                // Delete old images
                if ($toko->gambar) {
                    $oldImages = json_decode($toko->gambar, true);
                    foreach ($oldImages as $oldImage) {
                        if(file_exists(public_path('images/toko/' . $oldImage))) {
                            unlink(public_path('images/toko/' . $oldImage));
                        }
                    }
                }

                // Upload new images
                $gambarNames = [];
                foreach($request->file('gambar') as $image) {
                    $nama_gambar = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images/toko'), $nama_gambar);
                    $gambarNames[] = $nama_gambar;
                }

                $validated['gambar'] = json_encode($gambarNames);
            }

            // Update toko
            $toko->update($validated);

            return redirect()
                ->route('admin.toko.index')
                ->with('success', 'Toko berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui toko: ' . $e->getMessage());
        }
    }

    public function destroy(Toko $toko)
    {
        try {
            // Delete images if exists
            if ($toko->gambar) {
                $images = json_decode($toko->gambar, true);
                foreach ($images as $image) {
                    if(file_exists(public_path('images/toko/' . $image))) {
                        unlink(public_path('images/toko/' . $image));
                    }
                }
            }

            // Delete toko
            $toko->delete();

            return redirect()
                ->route('admin.toko.index')
                ->with('success', 'Toko berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus toko: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Toko $toko)
    {
        try {
            $toko->update([
                'status' => !$toko->status
            ]);

            return redirect()
                ->route('admin.toko.index')
                ->with('success', 'Status toko berhasil diubah');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mengubah status toko: ' . $e->getMessage());
        }
    }

    public function getStatus(Toko $toko)
    {
        return response()->json([
            'status' => $toko->status,
            'is_open' => $toko->is_open,
            'status_text' => $toko->status_text
        ]);
    }
}
