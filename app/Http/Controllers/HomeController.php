<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Toko;
use App\Models\Umpan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $spots = Spot::where('status', true)->latest()->take(3)->get();
        $tokos = Toko::where('status', true)->latest()->take(3)->get();
        $umpans = Umpan::where('status', true)->latest()->take(3)->get();

        return view('user.pages.home', compact('spots', 'tokos', 'umpans'));
    }

    public function spotIndex()
    {
        $spots = Spot::where('status', true)
            ->get();
        return view('user.pages.spot', compact('spots'));
    }

    public function tokoIndex()
    {
        $tokos = Toko::where('status', true)
            ->get();

        return view('user.pages.toko', compact('tokos'));
    }

    public function umpanIndex()
    {
        $umpans = Umpan::where('status', true)
            ->latest()
            ->paginate(9);
        return view('user.pages.umpan', compact('umpans'));
    }
}  
