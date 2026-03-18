<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data guru yang sedang login beserta jadwalnya
        $guru = Auth::user();
        $jadwal_saya = $guru->jadwals()->with('mapel')->get();

        return view('dashboard', compact('guru', 'jadwal_saya'));
    }
}