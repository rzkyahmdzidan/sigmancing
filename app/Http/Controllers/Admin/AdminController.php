<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spot;
use App\Models\Toko;
use App\Models\Umpan;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get all data from respective models
        $spots = Spot::all();
        $tokos = Toko::all();
        $umpans = Umpan::all();

        return view('admin.dashboard', [
            'totalSpots' => $spots->count(),
            'totalToko' => $tokos->count(),
            'totalUmpan' => $umpans->count(),
            'rekomendasi_umpan' => $umpans
        ]);
    }

    public function umpanIndex()
    {
        $umpans = Umpan::latest()->paginate(12);
        return view('admin.umpan.index', compact('umpans'));
    }
}
