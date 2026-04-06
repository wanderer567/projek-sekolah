<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return back()->with('success', 'Data siswa berhasil diimport!');
    }

    public function index(Request $request)
    {
        $query = Siswa::query();

        // Filter berdasarkan kelas jika dipilih
        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('kelas', $request->kelas);
        }

        // GANTI ->get() menjadi ->paginate(10) agar fungsi links() di blade jalan
        $siswas = $query->orderBy('nomor_absen', 'asc')->paginate(60)->withQueryString();

        return view('admin.data-siswa', compact('siswas'));
    }

    public function filter(Request $request)
    {
        $query = Siswa::query();

        if ($request->kelas) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $siswas = $query->orderBy('nomor_absen', 'asc')->get();

        return response()->json($siswas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_absen' => 'required|integer',
            'nama' => 'required',
            'nisn' => 'required|unique:siswa,nisn',
            'kelas' => 'required',
        ]);

        // Tambahkan logic generate qr_token otomatis jika belum ada di SiswaImport/Model
        Siswa::create([
            'nomor_absen' => $request->nomor_absen,
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'qr_token' => bin2hex(random_bytes(8)), // Generate token unik buat QR
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_absen' => 'required|integer',
            'nama' => 'required',
            'nisn' => 'required|unique:siswa,nisn,' . $id,
            'kelas' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);

        $siswa->update([
            'nomor_absen' => $request->nomor_absen,
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        Siswa::destroy($id);
        return redirect()->back()->with('success', 'Data siswa berhasil dihapus!');
    }
}