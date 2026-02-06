<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data siswa dari database
        $list_siswa = Siswa::all();

        // Kirim data ke file view bernama 'siswa.index'
        return view('siswa.index', compact('list_siswa'));
    }
}