<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;           
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
{
    // Mengambil data user yang rolenya guru
    $gurus = \App\Models\User::where('role', 'guru')->get();

    // Mengirim variabel $gurus ke view admin.data-guru
    return view('admin.data-guru', compact('gurus'));
}
    public function store(Request $request) {
    $request->validate([
        'name' => 'required',
        'nip' => 'required|unique:users,nip', 
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'nip' => $request->nip,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'guru',
    ]);

    return redirect()->back()->with('success', 'Guru berhasil ditambahkan!');
}

public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    $data = [
        'name' => $request->name,
        'nip' => $request->nip,
        'email' => $request->email,
    ];
    if ($request->filled('password')) { $data['password'] = Hash::make($request->password); }
    
    $user->update($data);
    return redirect()->back()->with('success', 'Data guru diperbarui!');
}
}
