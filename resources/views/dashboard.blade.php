@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-gray-800">Dashboard Statistik</h2>
    <p class="text-gray-600">{{ date('d F Y') }}</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm uppercase font-bold">Total Siswa</p>
        <p class="text-2xl font-bold text-gray-800">1.240</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
        <p class="text-gray-500 text-sm uppercase font-bold">Hadir Hari Ini</p>
        <p class="text-2xl font-bold text-gray-800">1.150</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
        <p class="text-gray-500 text-sm uppercase font-bold">Izin/Sakit</p>
        <p class="text-2xl font-bold text-gray-800">65</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500">
        <p class="text-gray-500 text-sm uppercase font-bold">Tanpa Keterangan</p>
        <p class="text-2xl font-bold text-gray-800">25</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-700">Absensi Kelas Terbaru</h3>
        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">Lihat Semua</button>
    </div>
    <table class="w-full text-left">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">Nama Siswa</th>
                <th class="px-6 py-4">Kelas</th>
                <th class="px-6 py-4">Waktu</th>
                <th class="px-6 py-4">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">Zaid Ali</td>
                <td class="px-6 py-4 text-gray-600">XII RPL 1</td>
                <td class="px-6 py-4 text-gray-600">07:05 WIB</td>
                <td class="px-6 py-4">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Hadir</span>
                </td>
            </tr>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-900">Budi Santoso</td>
                <td class="px-6 py-4 text-gray-600">XII RPL 2</td>
                <td class="px-6 py-4 text-gray-600">07:15 WIB</td>
                <td class="px-6 py-4">
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Izin</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection