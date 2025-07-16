<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spot;
use App\Models\Umpan;
use Illuminate\Http\Request;

class SpotController extends Controller
{
    public function index()
    {
        $spots = Spot::with('umpans')->latest()->paginate(9);
        return view('frontend.spot', compact('spots'));
    }

    public function adminIndex()
    {
        $spots = Spot::latest()->paginate(10);
        $umpans = Umpan::where('status', true)->get();
        return view('admin.spot.index', compact('spots', 'umpans'));
    }

    public function detail(Spot $spot)
    {
        return view('frontend.spot.detail', compact('spot'));
    }

    public function create()
    {
        $umpans = Umpan::where('status', true)->get();
        return view('admin.spot.modals.add', compact('umpans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_spot' => 'required|max:255',
            'lokasi' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'deskripsi' => 'required',
            'jenis_ikan' => 'required',
            'rekomendasi_umpan' => 'required|array',
            'rekomendasi_umpan.*' => 'exists:umpans,id',
            'rekomendasi_cuaca' => 'required',
            'harga_parkir' => 'nullable|integer',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|boolean'
        ]);

        // Handle multiple image upload
        $gambarNames = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $image) {
                $nama_gambar = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images/spots'), $nama_gambar);
                $gambarNames[] = $nama_gambar;
            }
        }

        // Get umpan details for saving to rekomendasi_umpan column
        $umpanIds = $request->rekomendasi_umpan;
        $umpanText = "";

        if (!empty($umpanIds)) {
            $umpans = Umpan::whereIn('id', $umpanIds)->get();
            $umpanDetails = [];

            foreach ($umpans as $umpan) {
                $umpanDetails[] = $umpan->nama;
            }

            $umpanText = !empty($umpanDetails) ? implode(", ", $umpanDetails) : "Tidak ada";
        } else {
            $umpanText = "Tidak ada";
        }

        // Prepare spot data including rekomendasi_umpan
        $spotData = collect($validated)->except('rekomendasi_umpan')->toArray();

        // Diperbaiki: Tetapkan default 0 untuk harga_parkir yang kosong
        if (empty($spotData['harga_parkir'])) {
            $spotData['harga_parkir'] = 0;
        }

        $spotData['gambar'] = !empty($gambarNames) ? json_encode($gambarNames) : null;
        $spotData['rekomendasi_umpan'] = $umpanText; // Save as text in the column

        // Pastikan rekomendasi_cuaca tidak kosong
        if (empty($spotData['rekomendasi_cuaca'])) {
            $spotData['rekomendasi_cuaca'] = "Tidak ada";
        }

        // Create spot
        $spot = Spot::create($spotData);

        // Attach umpan to spot (keep this for the relation)
        if (!empty($request->rekomendasi_umpan)) {
            $spot->umpans()->attach($request->rekomendasi_umpan);
        }

        return redirect()->route('admin.spot.index')
            ->with('success', 'Spot berhasil ditambahkan');
    }

    public function show(Spot $spot)
    {
        return view('frontend.spot.show', compact('spot'));
    }

    public function edit(Spot $spot)
    {
        try {
            $spot->load('umpans');
            return response()->json($spot);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data spot'], 500);
        }
    }

    public function update(Request $request, Spot $spot)
    {
        $validated = $request->validate([
            'nama_spot' => 'required|max:255',
            'lokasi' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'deskripsi' => 'required',
            'jenis_ikan' => 'required',
            'rekomendasi_umpan' => 'required|array',
            'rekomendasi_umpan.*' => 'exists:umpans,id',
            'rekomendasi_cuaca' => 'required',
            'harga_parkir' => 'nullable|integer',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'existing_images' => 'nullable',
            'deleted_images' => 'nullable|array',
            'status' => 'required|boolean'
        ]);

        // Persiapkan array gambar
        $gambarNames = [];

        // Gabungkan gambar yang sudah ada (kecuali yang dihapus)
        if ($request->has('existing_images') && !empty($request->existing_images)) {
            try {
                $existingImages = json_decode($request->existing_images, true);

                if (is_array($existingImages)) {
                    $gambarNames = $existingImages;
                } else {
                    // Fallback - coba ambil dari database jika decode gagal
                    $currentImages = json_decode($spot->gambar) ?? [];
                    $gambarNames = is_array($currentImages) ? $currentImages : [];
                }
            } catch (\Exception $e) {
                // Fallback ke gambar yang ada di database
                $currentImages = json_decode($spot->gambar) ?? [];
                $gambarNames = is_array($currentImages) ? $currentImages : [];
            }
        } else {
            // Jika tidak ada existing_images, gunakan gambar yang ada di database
            $currentImages = json_decode($spot->gambar) ?? [];
            $gambarNames = is_array($currentImages) ? $currentImages : [];
        }

        // Hapus gambar yang dipilih untuk dihapus
        if ($request->has('deleted_images')) {
            foreach ($request->deleted_images as $deletedImage) {
                $path = public_path('images/spots/' . $deletedImage);
                if (file_exists($path)) {
                    unlink($path);
                }

                // Hapus dari array gambar jika masih ada
                $index = array_search($deletedImage, $gambarNames);
                if ($index !== false) {
                    unset($gambarNames[$index]);
                }
            }

            // Reindex array
            $gambarNames = array_values($gambarNames);
        }

        // Tambahkan gambar baru
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $image) {
                try {
                    $nama_gambar = time() . '_' . $image->getClientOriginalName();
                    $uploaded = $image->move(public_path('images/spots'), $nama_gambar);

                    if ($uploaded) {
                        $gambarNames[] = $nama_gambar;
                    }
                } catch (\Exception $e) {
                    // Tangani error tanpa logging
                }
            }
        }

        // Get umpan details for saving to rekomendasi_umpan column
        $umpanIds = $request->rekomendasi_umpan;
        $umpanText = "";

        if (!empty($umpanIds)) {
            $umpans = Umpan::whereIn('id', $umpanIds)->get();
            $umpanDetails = [];

            foreach ($umpans as $umpan) {
                $umpanDetails[] = $umpan->nama;
            }

            $umpanText = !empty($umpanDetails) ? implode(", ", $umpanDetails) : "Tidak ada";
        } else {
            $umpanText = "Tidak ada";
        }

        // Persiapkan data spot untuk update
        $spotData = collect($validated)->except(['rekomendasi_umpan', 'existing_images', 'deleted_images'])->toArray();

        // Diperbaiki: Tetapkan default 0 untuk harga_parkir yang kosong
        if (empty($spotData['harga_parkir'])) {
            $spotData['harga_parkir'] = 0;
        }

        $spotData['gambar'] = !empty($gambarNames) ? json_encode($gambarNames) : null;
        $spotData['rekomendasi_umpan'] = $umpanText; // Simpan sebagai teks di kolom

        // Pastikan rekomendasi_cuaca tidak kosong
        if (empty($spotData['rekomendasi_cuaca'])) {
            $spotData['rekomendasi_cuaca'] = "Tidak ada";
        }

        // Update spot
        $spot->update($spotData);

        // Sync hubungan umpan
        if (!empty($request->rekomendasi_umpan)) {
            $spot->umpans()->sync($request->rekomendasi_umpan);
        } else {
            $spot->umpans()->detach();
        }

        return redirect()->route('admin.spot.index')
            ->with('success', 'Spot berhasil diperbarui');
    }

    public function destroy(Spot $spot)
    {
        // Delete all images
        $images = json_decode($spot->gambar) ?? [];
        foreach ($images as $image) {
            $path = public_path('images/spots/' . $image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Delete relationships and spot
        $spot->umpans()->detach();
        $spot->delete();

        return redirect()->route('admin.spot.index')
            ->with('success', 'Spot berhasil dihapus');
    }

    public function toggleStatus(Spot $spot)
    {
        $spot->update([
            'status' => !$spot->status
        ]);

        return redirect()->back()->with('success', 'Status spot berhasil diubah');
    }

    public function search(Request $request)
    {
        $query = Spot::query();

        if ($request->has('search')) {
            $query->where('nama_spot', 'like', '%' . $request->search . '%');
        }

        if ($request->has('lokasi') && $request->lokasi !== '') {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $spots = $query->latest()->paginate(10);
        $umpans = Umpan::where('status', true)->get();
        return view('admin.spot.index', compact('spots', 'umpans'));
    }
}
