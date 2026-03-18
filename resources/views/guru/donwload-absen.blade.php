@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<scrip src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div x-data="attendanceApp()" class="min-h-screen p-4">

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Ringkasan Statistik</h2>
            <p class="text-indigo-600 font-medium mt-1">
                <i class="fas fa-calendar-alt mr-1"></i> 
                Periode: <span x-text="currentPeriod"></span>
            </p>
        </div>
        
        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
                <input type="text" x-model="search" placeholder="Cari nama siswa..." 
                    class="w-full py-2.5 pl-10 pr-4 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-indigo-500 shadow-sm">
            </div>

            <!-- <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-bold transition active:scale-95 shadow-sm">
                    Logout
                </button>
            </form> -->
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="totalSiswa"></p>
            </div>
            <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Hadir</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="countHadir"></p>
            </div>
            <div class="p-3 bg-green-50 rounded-xl text-green-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Izin / Sakit</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="countSakitIzin"></p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600">
                <i class="fas fa-file-medical text-xl"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Alpa</p>
                <p class="text-3xl font-bold text-gray-800 mt-1" x-text="countAlpa"></p>
            </div>
            <div class="p-3 bg-red-50 rounded-xl text-red-600">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
        </div>
    </div>


@endsection