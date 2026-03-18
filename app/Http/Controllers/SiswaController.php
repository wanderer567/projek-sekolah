<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index() {
    $siswas = Siswa::orderBy('nomor_absen', 'asc')->get();
    return view('admin.data-siswa', compact('siswas'));
}

public function store(Request $request) {
    $request->validate([
        'nomor_absen' => 'required|integer',
        'nama' => 'required',
        'nisn' => 'required|unique:siswa,nisn',
        'kelas' => 'required',
    ]);
    Siswa::create($request->all());
    return redirect()->back()->with('success', 'Data siswa berhasil ditambah!');
}

public function update(Request $request, $id) {
    $siswa = Siswa::findOrFail($id);
    $siswa->update($request->all());
    return redirect()->back()->with('success', 'Data siswa berhasil diupdate!');
}

public function destroy($id) {
    Siswa::destroy($id);
    return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
}
}