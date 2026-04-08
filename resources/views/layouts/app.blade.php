<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <div class="bg-indigo-900 text-white w-64 py-6 px-4 fixed h-full shadow-xl flex flex-col">
            <h1 class="text-2xl font-bold mb-10 text-center tracking-wider">SI ABSEN</h1>
        
            <nav class="space-y-2 flex-1">
                <p class="px-4 text-[10px] font-semibold text-indigo-300 uppercase mb-4 tracking-widest">Menu Utama</p>
                
                <a href="/dashboard" class="flex items-center py-3 px-4 rounded-xl transition duration-200 hover:bg-white/10 {{ Request::is('dashboard') ? 'bg-white text-indigo-900 font-bold shadow-lg' : '' }}">
                    <i class="fas fa-desktop w-6 text-center mr-3 text-lg"></i> Dashboard
                </a>

                <a href="/manual" class="flex items-center py-3 px-4 rounded-xl transition duration-200 hover:bg-white/10 {{ Request::is('manual') ? 'bg-white text-indigo-900 font-bold shadow-lg' : '' }}">
                    <i class="fas fa-user-edit w-6 text-center mr-3 text-lg"></i> Absen Manual
                </a>

                <a href="/qr" class="flex items-center py-3 px-4 rounded-xl transition duration-200 hover:bg-white/10 {{ Request::is('qr') ? 'bg-white text-indigo-900 font-bold shadow-lg' : '' }}">
                    <i class="fas fa-qrcode w-6 text-center mr-3 text-lg"></i> Absen Qr
                </a>

                <a href="/download" class="flex items-center py-3 px-4 rounded-xl transition duration-200 hover:bg-white/10 {{ Request::is('download') ? 'bg-white text-indigo-900 font-bold shadow-lg' : '' }}">
                    <i class="fas fa-download w-6 text-center mr-3 text-lg"></i> Download Absen
                    <center>
                    <nav class="space-y-2 flex-1">
                <p class="px-4 text-[8px] font-semibold text-indigo-300 uppercase mb-4 tracking-widest">Fitur Ini masih Dalam Pengembangan</p>
               </center>      
               </a>

                @if(auth()->check() && auth()->user()->role == 'admin')
    <div class="pt-4 mt-4 border-t border-indigo-800">
        <p class="px-4 text-[10px] font-semibold text-indigo-300 uppercase mb-4 tracking-widest">Manajemen Data</p>
        
        <a href="/admin/data-siswa" class="flex items-center py-3 px-4 rounded-xl transition duration-200 hover:bg-white/10 {{ Request::is('admin/data-siswa') ? 'bg-white text-indigo-900 font-bold shadow-lg' : '' }}">
            <i class="fas fa-users w-6 text-center mr-3 text-lg"></i> Data Siswa
        </a>

        <a href="/admin/data-guru" class="flex items-center py-3 px-4 rounded-xl transition duration-200 hover:bg-white/10 {{ Request::is('admin/data-guru') ? 'bg-white text-indigo-900 font-bold shadow-lg' : '' }}">
            <i class="fas fa-user-tie w-6 text-center mr-3 text-lg"></i> Data Guru
        </a>
    </div>
@endif
            </nav>

            <div class="pt-6 border-t border-indigo-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-indigo-300 hover:text-white transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 ml-64 p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>