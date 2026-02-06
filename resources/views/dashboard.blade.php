@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-semibold text-gray-800">Ringkasan Statistik</h2>
        <p class="text-indigo-600 font-medium">Periode: {{ ucfirst(request('range') ?? 'Hari Ini') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 transform transition hover:-translate-y-1">
        <p class="text-gray-500 text-sm uppercase font-bold">Total Siswa</p>
        <p class="text-2xl font-bold text-gray-800">36</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500 transform transition hover:-translate-y-1">
        <p class="text-gray-500 text-sm uppercase font-bold">Izin</p>
        <p class="text-2xl font-bold text-gray-800">2</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500 transform transition hover:-translate-y-1">
        <p class="text-gray-500 text-sm uppercase font-bold">Sakit</p>
        <p class="text-2xl font-bold text-gray-800">1</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500 transform transition hover:-translate-y-1">
        <p class="text-gray-500 text-sm uppercase font-bold">Alpa</p>
        <p class="text-2xl font-bold text-gray-800">0</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-700">Detail Absensi Siswa</h3>
        
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center hover:bg-indigo-700 transition">
                <i class="fas fa-filter mr-2"></i> Pilih Periode
                <i class="fas fa-chevron-down ml-2 text-xs"></i>
            </button>

            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl z-50">
                <div class="py-1">
                    <a href="?range=hari" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 border-b border-gray-50 text-left">Hari Ini</a>
                    <a href="?range=minggu" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 border-b border-gray-50 text-left">Minggu Ini</a>
                    <a href="?range=bulan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 border-b border-gray-50 text-left">Bulan Ini</a>
                    <a href="?range=semester" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 text-left">Semester Ini</a>
                </div>
            </div>
        </div>
    </div>
    
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Nama Siswa</th>
                <th class="px-6 py-4">Waktu</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Keterangan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 text-sm">
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">Zaid Ali</td>
                <td class="px-6 py-4 text-gray-600">07:05 WIB</td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">Hadir</span>
                </td>
                <td class="px-6 py-4 text-gray-400 italic">Tepat waktu</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection